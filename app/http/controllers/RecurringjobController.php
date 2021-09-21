<?php

/**
* RecurringjobController
*/
class RecurringjobController extends Controller
{
	private $recurringjobModel;
	function __construct()
	{
		parent::__construct();
		$this->commons = new CommonsController();
		/*Intilize User model*/
		$this->recurringjobModel = new Recurringjob();
	}

	public function index()
	{
		$data['code'] = $this->url->get('code');
		$token = $this->recurringjobModel->getToken();
		if ($data['code'] != $token) {
			exit('Access Denied');
		}
		$count = 0;
		$inv_arr = [];
		$data['rinvoices'] = $this->recurringjobModel->getRecurringInvoices();
		$today = date('Y-m-d');
		if (!empty($data['rinvoices'])) {
			foreach ($data['rinvoices'] as $key => $value) {
				if (!empty($value['last_invoice'])) {
					$repeatdate = Date("Y-m-d", strtotime( $value['last_invoice']. ' + '. $value['repeat_every']));
					$last_date = date_format(date_create($value['last_invoice']), 'Y-m-d');
					if (strtotime($today) > strtotime($repeatdate)) {
						$this->createInvoiceFromRecurring($value);
						$count = $count + 1;
						array_push($inv_arr, $value['id']);
					}
				} elseif (empty($value['last_invoice'])) {
					$repeatdate = date_format(date_create($value['inv_date']), 'Y-m-d');
					if (strtotime($today) > strtotime($repeatdate)) {
						$this->createInvoiceFromRecurring($value);
						$count = $count + 1;
						array_push($inv_arr, $value['id']);
					}
				}
			}
		}
		
		$logs = json_encode(array('count' => $count, 'inv' => json_encode($inv_arr)));
		$this->recurringjobModel->createCronLog($logs);
		exit();
	}

	public function createInvoiceFromRecurring($data)
	{
		$data['status'] = "Unpaid";
		$data['paid'] = 0.00;
		$data['duedate'] = date_format(date_create(), 'Y-m-d');
		$data['paiddate'] = date_format(date_create(), 'Y-m-d');
		$data['due'] = $data['amount'];
		$result = $this->recurringjobModel->createInvoice($data);
		$this->createPDF($result);
		$this->invoiceMail($result);
		echo "Invoice Created Successfully". $result.'<br />';
	}

	public function createPDF($id)
	{
		require DIR_BUILDER.'libs/tcpdf/tcpdf.php';
		/**
		* Get all User data from DB using Invoice model 
		**/
		$result = $this->recurringjobModel->getInoviceView($id);
		$caddress = json_decode($result['address'], true);
		$items = json_decode($result['items'], true);
		
		$info = $this->recurringjobModel->getOrganization();
		$organization = $info['name'];
		$logo = $info['logo'];
		$address = json_decode($info['address'], true);
		$item = '';
		foreach ($items as $key => $value) {
			$tax = NULL;
			if (!empty($value['tax'])) { 
				foreach ($value['tax'] as $tax_key => $tax_value) {
					$tax .= '<p class="badge badge-light badge-sm badge-pill d-block m-1 text-left">'.$tax_value['name'].' &#8658; '.$tax_value['tax_price'].'</p>';
				}
			}

			$item .= '<tr>
			<td class="item" width="320">'.$value['name'].'<br /><span style="color: #555;">'.$value['descr'].'</span></td>
			<td width="40">'.$value['quantity'].'</td>
			<td width="110">'.$value['cost'].'</td>
			<td width="80">'.$value['taxprice'].'</td>
			<td width="120">'.$value['price'].'</td>
			</tr>';
		}

		/*Load Language File*/
		require DIR_BUILDER.'language/'.$info['language'].'/common.php';
		$data['lang']['common'] = $lang;
		require DIR_BUILDER.'language/'.$info['language'].'/invoices.php';
		$data['lang']['invoices'] = $invoices;

		// create new PDF document
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor($organization);
		$pdf->SetTitle('Invoice | PDF');
		$pdf->SetSubject($info['name'].' | Invoice');
		$pdf->SetKeywords('Invoice PDF');
		
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);

		$pdf->SetMargins(5, 0, 5);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

		if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
			require_once(dirname(__FILE__).'/lang/eng.php');
			$pdf->setLanguageArray($l);
		}

		$pdf->SetFont('dejavusans', '', 10);

		// add a page
		$pdf->AddPage();
		$html = '<style>
		.text-center {
			text-align: center;
		}
		.text-right {
			text-align: right;
		}
		.inv-template {
			width: 100%;
			background-color: #FFF;
			box-shadow: 0 0 10px 0 rgba(150, 150, 150, 0.2); 
		}
		.inv-title {
			font-size: 32px;
			color: #555;
		}
		.inv-head td {
			padding: 0 0 2px 0;
			border-bottom: 1px solid #eee;
		}
		.inv-template-bdy table {
			width: 100%; 
		}
		.inv-template-bdy .inv-logo {
			text-align: center; 
		}
		.inv-template-bdy .inv-logo img {
			height: 40px; 
		}
		.inv-bill-to p {
			font-size: 10px;
			color: #777;
		}
		.inv-bill-to span {
			font-size: 10px;
			color: #777;
		}
		.inv-bill-to .title {
			font-size: 16px;
			color: #333;
			font-weight: 500;
		}
		.inv-bill-to .email {
			color: #333;
			font-weight: 500;
			margin: 0;
		}
		.inv-meta {
			font-size: 10px;
		}
		.inv-template-item {
			font-size: 10px;
			padding: 0 20px 0 20px;
		}
		.inv-template-item td {
			border: 1px solid #EEE; 
		}
		.inv-template-item .balance-due {
			background-color: #f8f8f8; 
		}
		.total td {
			vertical-align: middle;
		}
		.inv-template-bdy .inv-meta p span {
			display: inline-block;
			vertical-align: middle;
		}
		.inv-template-bdy .inv-meta p span:nth-last-child(1) {
			font-weight: 500;
			min-width: 100px;
		}
		</style>

		<div class="inv-template">
		<div class="inv-template-bdy">
		<table cellpadding="8">
		<thead>
		<tr>
		<th></th>
		<th></th>
		<th></th>
		</tr>
		</thead>
		<tbody>
		<tr class="inv-head">
		<td class="inv-address" style="vertical-align: middle;">
		<div>
		<span class="head">'.$organization.'<br></span>
		<span class="body">'.$address['address1'].'<br></span>
		<span class="body">'.$address['address2'].' '.$address['city'].'<br></span>
		<span class="body">'.$address['country'].' '.$address['pincode'].'<br></span>
		</div>
		</td>
		<td colspan="2" class="text-right inv-title" style="vertical-align: middle;">'.$data['lang']['common']['text_invoice'].'</td>
		</tr>
		<tr class="inv-meta-container">
		<td valign="middle">
		<div class="inv-bill-to">
		<span class="head">'.$data['lang']['invoices']['text_bill_to'].'</span><br />
		<span class="title">'.$result['company'].'</span><br />
		<span class="email">'.$result['email'].'</span><br />
		<span class="body">'.$caddress['address1'].', '.$caddress['address2'].'</span><br />
		<span class="body">'.$caddress['city'].', '.$caddress['state'].'</span> <br />
		<span class="body">'.$caddress['country'].'  '.$caddress['pin'].'</span>
		</div>
		</td>
		<td colspan="2" valign="middle" class="text-right">
		<div class="inv-meta">
		<span><span># : </span><span>INV-'.str_pad($result['id'], 4, '0', STR_PAD_LEFT).'</span></span>
		<p><span>'.$data['lang']['common']['text_created_date'].' : </span><span>'.date_format(date_create($result['date_of_joining']), 'd-m-Y').'</span></p>
		<p><span>'.$data['lang']['invoices']['text_due_date'].' : </span><span>'.date_format(date_create($result['duedate']), 'd-m-Y').'</span></p>
		<p><span>'.$data['lang']['invoices']['text_payment_method'].': </span><span>'.$result['payment'].'</span></p>
		<p><span>'.$data['lang']['common']['text_status'].' : </span><span>'.$result['status'].'</span></p>
		</div>
		</td>
		</tr>
		</tbody>
		</table>
		<div class="inv-template-item">
		<table cellpadding="8">
		<thead>
		<tr style="background-color: #eee;" border="1">
		<th width="280">'.$data['lang']['invoices']['text_item_and_description'].'</th>
		<th width="50">'.$data['lang']['invoices']['text_quantity'].'</th>
		<th width="100">'.$data['lang']['invoices']['text_unit_cost'].'('.$result['currency_abbr'].')</th>
		<th width="160">'.$data['lang']['invoices']['text_tax'].' ('.$result['currency_abbr'].')</th>
		<th width="120">'.$data['lang']['invoices']['text_price'].' ('.$result['currency_abbr'].')</th>
		</tr>
		</thead>
		<tbody>
		'.$item.'
		<tr class="total">
		<td width="330" rowspan="6" colspan="3">'.$result['note'].'</td>
		<td width="180" colspan="2" align="right">Sub Total</td>
		<td width="200" colspan="2">'.$result['currency_abbr'].' '.$result['subtotal'].'</td>
		</tr>
		<tr class="total">
		<td width="180" colspan="2" align="right">Tax</td>
		<td width="200" colspan="2">'.$result['currency_abbr'].' '.$result['tax'].'</td>
		</tr>
		<tr class="total">
		<td width="180" colspan="2" align="right">Discount (Flat)</td>
		<td width="200" colspan="2">'.$result['currency_abbr'].' '.$result['discount_value'].'</td>
		</tr>
		<tr class="total">
		<td width="180" colspan="2" align="right">Total</td>
		<td width="200" colspan="2">'.$result['currency_abbr'].' '.$result['amount'].'</td>
		</tr>
		<tr class="total">
		<td width="180" colspan="2" align="right">Paid</td>
		<td width="200" colspan="2">'.$result['currency_abbr'].' '.$result['paid'].'</td>
		</tr>
		<tr class="total" style="background-color: #f8f8f8;">
		<td width="180" colspan="2" align="right">Balance Due</td>
		<td width="200" colspan="2">'.$result['currency_abbr'].' '.$result['due'].'</td>
		</tr>
		<tr>
		<td colspan="8">
		<p class="font-12">Terms &#38; Conditions</p>
		<p class="font-16">'.$result['tc'].'</p>
		</td>
		</tr>
		</tbody>
		</table>
		</div>
		</div>
		</div>';

		$pdf->writeHTML($html, true, false, true, false, '');
		$pdf->Output(DIR.'public/uploads/pdf/invoice-'.$id.'.pdf', 'F');
	}
	/**
	* Invoice invoice mail method
	* This method will be called on to mail invoice details when adding new invoices
	**/
	private function invoiceMail($id)
	{
		$data = $this->recurringjobModel->getInoviceView($id);
		$info = $this->recurringjobModel->getOrganization();
		$data['id'] = str_pad($data['id'], 4, '0', STR_PAD_LEFT);
		$template = $this->recurringjobModel->getTemplate('newinvoice');
		$site_link = '<a href="'.URL_CLIENTS.DIR_ROUTE.'invoice/view&id='.$id.'">Click Here</a>';
		
		$message = $template['message'];
		$message = str_replace('{company}', $data['company'], $message);
		$message = str_replace('{inv_id}', 'INV-'.$data['id'], $message);
		$message = str_replace('{amount}', $data['currency_abbr'].$data['amount'], $message);
		$message = str_replace('{paid}', $data['currency_abbr'].$data['paid'], $message);
		$message = str_replace('{due}', $data['currency_abbr'].$data['due'], $message);
		$message = str_replace('{due_date}', $data['duedate'], $message);
		$message = str_replace('{business_name}', $info['name'], $message);
		$message = str_replace('{inv_url}', $site_link, $message);
		
		$mailer = new Mailer();
		$useornot = $mailer->getData();
		if (!$useornot) {
			$mailer->mail->setFrom($info['email'], $info['name']);
		}
		$mailer->mail->addAddress($data['email'], $data['company']);
		$mailer->mail->addBCC($info['email'], $info['name']);
		$mailer->mail->addAttachment(DIR.'public/uploads/pdf/invoice-'.$id.'.pdf','Invoice.pdf');
		$mailer->mail->isHTML(true);
		$mailer->mail->Subject = $template['subject'];
		$mailer->mail->Body = html_entity_decode($message);
		$mailer->mail->AltBody = 'Hello '.$data['customer'].'.
		Your Invoice has been created on '.$data['date_of_joining'].'
		Your Invoice ID : '.$data['id'].'';
		$mailer->sendMail();
	}
}