<?php

/**
* ProposalController
*/
use Dompdf\Dompdf;
use Dompdf\Options;

class QuoteController extends Controller
{
	private $quoteModel;
	function __construct()
	{
		parent::__construct();
		$this->commons = new CommonsController();
		/*Intilize User model*/
		$this->quoteModel = new Quote();
	}
	/**
	* Quotes index method
	* This method will be called on Quotes list view
	**/
	public function index()
	{
		if (!$this->commons->hasPermission('quotes')) {
			Not_foundController::show('403');
			exit();
		}
		/*Get User name and role*/
		$data = $this->commons->getUser();
		/**
		* Get all User data from DB using User model 
		**/
		if ($user = $this->commons->checkUser()) {
			$data['result'] = $this->quoteModel->getQuotes($user);
		} else {
			$data['result'] = $this->quoteModel->getQuotes();
		}


		/*Load Language File*/
		require DIR_BUILDER.'language/'.$data['info']['language'].'/common.php';
		$data['lang']['common'] = $lang;
		require DIR_BUILDER.'language/'.$data['info']['language'].'/quotes.php';
		$data['lang']['quotes'] = $quotes;

		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}
		/* Set page title */
		$data['page_title'] = $data['lang']['common']['text_quotes'];
		
		/*Render User list view*/
		$this->view->render('quote/quote_list.tpl', $data);
	}
	/**
	* Quotes index View method
	* This method will be called on Quotes View view
	**/
	public function indexView()
	{
		if (!$this->commons->hasPermission('quote/view')) {
			Not_foundController::show('403');
			exit();
		}
		/**
		* Check if id exist in url if not exist then redirect to Invoice list view 
		**/
		$id = (int)$this->url->get('id');
		if (empty($id) || !is_int($id)) {
			$this->url->redirect('quotes');
		}
		/*Get User name and role*/
		$data = $this->commons->getUser();
		/**
		* Get all User data from DB using Invoice model 
		**/
		if ($user = $this->commons->checkUser()) {
			$data['result'] = $this->quoteModel->getQuoteView($id, $user);
		} else {
			$data['result'] = $this->quoteModel->getQuoteView($id);
		}

		if (empty($data['result'])) {
			$this->url->redirect('quotes');
		}

		/*Load Language File*/
		require DIR_BUILDER.'language/'.$data['info']['language'].'/common.php';
		$data['lang']['common'] = $lang;
		require DIR_BUILDER.'language/'.$data['info']['language'].'/quotes.php';
		$data['lang']['quotes'] = $quotes;

		$data['info']['address'] = json_decode($data['info']['address'], true);
		$data['result']['address'] = json_decode($data['result']['address'], true);
		$data['result']['items'] = json_decode($data['result']['items'], true);
		$data['result']['total'] = json_decode($data['result']['total'], true);
		
		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}
		/**
		* Get all User data from DB using Invoice model 
		**/
		/* Set page title */
		$data['page_title'] = $data['lang']['quotes']['text_quote_view'];
		
		/*Render User list view*/
		$this->view->render('quote/quote_view.tpl', $data);
	}
	/**
	* Quotes index Print method
	* This method will be called on Quotes Print view
	**/
	public function indexPrint()
	{
		/**
		* Check if id exist in url if not exist then redirect to Invoice list view 
		**/
		$id = (int)$this->url->get('id');
		if (empty($id) || !is_int($id)) {
			$this->url->redirect('quotes');
		}
		
		$id = (int)$this->url->get('id');
		if (empty($id) || !is_int($id)) {
			$this->url->redirect('quotes');
		}
		require DIR_BUILDER.'libs/dompdf/autoload.inc.php';
		$html_array = $this->createPDFHTML($id, 1);
		
		$dompdf = new Dompdf();
		$dompdf->loadHtml($html_array['html']);
		// (Optional) Setup the paper size and orientation
		$dompdf->setPaper('letter');
		// Render the HTML as PDF
		$dompdf->render();
		// Output the generated PDF to Browser
		$dompdf->stream("Quotation.pdf", array("Attachment" => false));
	}
	/**
	* Quotes index ADD method
	* This method will be called on Quotes ADD view
	**/
	public function indexAdd()
	{
		if (!$this->commons->hasPermission('quote/add')) {
			Not_foundController::show('403');
			exit();
		}
		/*Get User name and role*/
		$data = $this->commons->getUser();
		
		/**
		* Get all User data from DB using User model 
		**/
		if ($user = $this->commons->checkUser()) {
			$data['user']['user_id'] = $this->session->data['user_id'];
			$data['admin'] = false;
			$data['customers'] = $this->quoteModel->getCustomers($user);
		} else {
			$data['admin'] = true;
			$data['customers'] = $this->quoteModel->getCustomers();
		}

		$data['result'] = NULL;
		$data['payment_type'] = $this->quoteModel->paymentType();
		$data['taxes'] = $this->quoteModel->getTaxes();
		$data['items'] = $this->quoteModel->getItems();
		$data['payment_status'] = $this->quoteModel->getPaymentStatus();
		$data['currency'] = $this->quoteModel->getCurrency();

		/*Load Language File*/
		require DIR_BUILDER.'language/'.$data['info']['language'].'/common.php';
		$data['lang']['common'] = $lang;
		require DIR_BUILDER.'language/'.$data['info']['language'].'/quotes.php';
		$data['lang']['quotes'] = $quotes;

		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}
		/* Set page title */
		$data['page_title'] = $data['lang']['quotes']['text_new_quote'];
		$data['action'] = URL.DIR_ROUTE.'quote/action';
		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);

		/*Render Invoice list view*/
		$this->view->render('quote/quote_form.tpl', $data);
	}
	/**
	* Quotes index Edit method
	* This method will be called on Quotes Edit view
	**/
	public function indexEdit()
	{
		if (!$this->commons->hasPermission('quote/edit')) {
			Not_foundController::show('403');
			exit();
		}
		/**
		* Check if id exist in url if not exist then redirect to Item list view 
		**/
		$id = (int)$this->url->get('id');
		if (empty($id) || !is_int($id)) {
			$this->url->redirect('quotes');
		}
		/*Get User name and role*/
		$data = $this->commons->getUser();
		/**
		* Get all User data from DB using User model 
		**/
		if ($user = $this->commons->checkUser()) {
			$data['user']['user_id'] = $this->session->data['user_id'];
			$data['admin'] = false;
			$data['result'] = $this->quoteModel->getQuote($id, $user);
			$data['customers'] = $this->quoteModel->getCustomers($user);
		} else {
			$data['admin'] = true;
			$data['result'] = $this->quoteModel->getQuote($id);
			$data['customers'] = $this->quoteModel->getCustomers();
		}

		if (empty($data['result'])) {
			$this->url->redirect('quotes');
		}

		$data['payment_type'] = $this->quoteModel->paymentType();
		$data['taxes'] = $this->quoteModel->getTaxes();
		$data['items'] = $this->quoteModel->getItems();
		$data['payment_status'] = $this->quoteModel->getPaymentStatus();
		$data['currency'] = $this->quoteModel->getCurrency();

		/*Load Language File*/
		require DIR_BUILDER.'language/'.$data['info']['language'].'/common.php';
		$data['lang']['common'] = $lang;
		require DIR_BUILDER.'language/'.$data['info']['language'].'/quotes.php';
		$data['lang']['quotes'] = $quotes;

		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}
		/* Set page title */
		$data['page_title'] = $data['lang']['quotes']['text_edit_quote'];
		$data['action'] = URL.DIR_ROUTE.'quote/action';
		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);

		/*Render User list view*/
		$this->view->render('quote/quote_form.tpl', $data);
	}
	/**
	* Quotes index Action method
	* This method will be called on Quotes Action view
	**/
	public function indexAction()
	{
		/**
		* Check if from is submitted or not 
		**/
		if (!isset($_POST['submit'])) {
			$this->url->redirect('quotes');
			exit();
		}
		/**
		* Validate form data
		* If some data is missing or data does not match pattern
		* Return to info view 
		**/
		if ($validate_field = $this->validateField()) {
			$this->session->data['message'] = array('alert' => 'error', 'value' => 'Please enter valid '.implode(", ",$validate_field).'!');
			if (!empty($this->url->post('id'))) {
				$this->url->redirect('quote/edit&id='.$this->url->post('id'));
			} else {
				$this->url->redirect('quotes');
			}
		}

		if ($this->commons->validateToken($this->url->post('_token'))) {
			$this->url->redirect('quotes');
		}

		if (!empty($this->url->post('id'))) {
			$data = $this->url->post('invoice');
			$data['item'] = json_encode($data['item']);
			$data['total'] = json_encode($data['total']);
			$data['date'] = date_format(date_create($data['date']), "Y-m-d");
			$data['expiry'] = date_format(date_create($data['expiry']), "Y-m-d");
			$data['id'] = $this->url->post('id');

			$result = $this->quoteModel->updateQuote($data);
			$this->createPdf($data['id']);
			$this->session->data['message'] = array('alert' => 'success', 'value' => 'Quotes updated successfully.');
			$this->url->redirect('quote/view&id='.$data['id']);
		}
		else {
			$data = $this->url->post('invoice');
			$data['item'] = json_encode($data['item']);
			$data['total'] = json_encode($data['total']);
			$data['date'] = date_format(date_create($data['date']), "Y-m-d");
			$data['expiry'] = date_format(date_create($data['expiry']), "Y-m-d");
			$result = $this->quoteModel->createQuote($data);
			$this->createPdf($result);
			$this->quoteMail($result);
			$this->session->data['message'] = array('alert' => 'success', 'value' => 'Quotes created successfully.');
			$this->url->redirect('quote/view&id='.$result);
		}
	}
	/**
	* Quotes index Delete method
	* This method will be called on Quotes Delete view
	**/
	public function indexDelete()
	{
		if (!$this->commons->hasPermission('quote/delete')) {
			Not_foundController::show('403');
			exit();
		}
		$result = $this->quoteModel->deleteQuote($this->url->post('id'));
		$this->session->data['message'] = array('alert' => 'success', 'value' => 'Quotes deleted successfully.');
		$this->url->redirect('quotes');
	}
	/**
	* Quotes index mail method
	* This method will be called to send mail
	**/
	public function quoteMail($id)
	{
		$data = $this->quoteModel->getQuoteView($id);
		$data['total'] = json_decode($data['total'], true);
		$info = $this->quoteModel->getOrganization();
		$template = $this->quoteModel->getTemplate('newquotes');
		$site_link = '<a href="'.URL_CLIENTS.DIR_ROUTE.'quote/view&id='.$id.'">Click Here</a>';
		
		$data['id'] = str_pad($data['id'], 4, '0', STR_PAD_LEFT);

		$message = $template['message'];

		$message = str_replace('{company}', $data['company'], $message);
		$message = str_replace('{project_name}', $data['project_name'], $message);
		$message = str_replace('{valid_until}', $data['expiry'], $message);
		$message = str_replace('{amount}', $data['currency_abbr'].$data['total']['amount'], $message);
		$message = str_replace('{quote_url}', $site_link, $message);
		$message = str_replace('{business_name}', $info['name'], $message);

		$mailer = new Mailer();
		$useornot = $mailer->getData();
		if (!$useornot) {
			$mailer->mail->setFrom($info['email'], $info['name']);
		}
		$mailer->mail->addAddress($data['email'], $data['company']);
		$mailer->mail->addBCC($info['email'], $info['name']);
		$mailer->mail->addAttachment(DIR.'public/uploads/pdf/quotes-'.$id.'.pdf', 'Quotation.pdf');
		$mailer->mail->isHTML(true);
		$mailer->mail->Subject = $template['subject'];
		$mailer->mail->Body = html_entity_decode($message);
		$mailer->mail->AltBody = 'Hello '.$data['company'].'.
		Here is the quote you requested for '.$data['project_name'].'
		Your quote ID : QTN-'.$data['id'].'';
		$mailer->sendMail();	
	}

	public function validateField()
	{
		$error = [];
		$error_flag = false;
		if ($this->commons->validateNumeric($this->url->post('invoice')['customer'])) {
			$error_flag = true;
			$error['customer'] = 'Customer Name!';
		}
		
		if ($error_flag) {
			return $error;
		} else {
			return false;
		}
	}
	/**
	* Quotes index PDF method
	* This method will be called to create Quotes's PDF
	**/
	public function indexPdf()
	{
		/**
		* Check if id exist in url if not exist then redirect to Invoice list view 
		**/
		$id = (int)$this->url->get('id');
		if (empty($id) || !is_int($id)) {
			$this->url->redirect('quotes');
		}
		require DIR_BUILDER.'libs/dompdf/autoload.inc.php';
		$html_array = $this->createPDFHTML($id);
		
		$dompdf = new Dompdf();
		$dompdf->loadHtml($html_array['html']);
		// (Optional) Setup the paper size and orientation
		$dompdf->setPaper('letter');
		// Render the HTML as PDF
		$dompdf->render();
		// Output the generated PDF to Browser
		$dompdf->stream("Quotation.pdf", array("Attachment" => false));
	}

	public function createPdf($id)
	{
		require DIR_BUILDER.'libs/dompdf/autoload.inc.php';
		$html_array = $this->createPDFHTML($id);
		
		$dompdf = new Dompdf();
		$dompdf->loadHtml($html_array['html']);
		// (Optional) Setup the paper size and orientation
		$dompdf->setPaper('letter');
		// Render the HTML as PDF
		$dompdf->render();
		// Output the generated PDF to Browser
		$output = $dompdf->output();
		file_put_contents(DIR.'public/uploads/pdf/quotes-'.$id.'.pdf', $output);
	}

	public function createPDFHTML($id, $printQuote = NULL)
	{
		/**
		* Get all User data from DB using Invoice model 
		**/
		if ($user = $this->commons->checkUser()) {
			$result = $this->quoteModel->getQuoteView($id, $user);
		} else {
			$result = $this->quoteModel->getQuoteView($id);
		}
		if (empty($result)) { $this->url->redirect('quotes'); }
		
		/*Get User name and role*/
		$data = $this->commons->getUser();

		/*Load Language File*/
		require DIR_BUILDER.'language/'.$data['info']['language'].'/common.php';
		$data['lang']['common'] = $lang;
		require DIR_BUILDER.'language/'.$data['info']['language'].'/quotes.php';
		$data['lang']['quotes'] = $quotes;

		$result['address'] = json_decode($result['address'], true);
		$result['items'] = json_decode($result['items'], true);
		$result['total'] = json_decode($result['total'], true);

		/*Get User name and role*/
		$data['info']['address'] = json_decode($data['info']['address'], true);
		$data['info']['invoice_setting'] = json_decode($data['info']['invoice_setting'], true);
		
		ob_start();
		include DIR_APP.'views/quote/quote_pdf_'.$data['info']['invoice_setting']['template'].'.tpl.php';
		//exit();
		$html = ob_get_clean();
		ob_end_flush();

		return array('html' => $html, 'info' => $data['info']);
	}

	public function createPDFHTML1($id)
	{
		/**
		* Get all User data from DB using Invoice model 
		**/
		
		if ($user = $this->commons->checkUser()) {
			$result = $this->quoteModel->getQuoteView($id, $user);
		} else {
			$result = $this->quoteModel->getQuoteView($id);
		}

		if (empty($result)) {
			$this->url->redirect('quotes');
		}

		/*Get User name and role*/
		$data = $this->commons->getUser();
		
		/*Load Language File*/
		require DIR_BUILDER.'language/'.$data['info']['language'].'/common.php';
		$data['lang']['common'] = $lang;
		require DIR_BUILDER.'language/'.$data['info']['language'].'/quotes.php';
		$data['lang']['quotes'] = $quotes;

		$caddress = json_decode($result['address'], true);

		$items = json_decode($result['items'], true);
		$total = json_decode($result['total'], true);

		$info = $data['info'];
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
			<td class="item" width="280">'.$value['name'].'<br /><span style="color: #555;">'.$value['descr'].'</span></td>
			<td width="50">'.$value['quantity'].'</td>
			<td width="100">'.$value['cost'].'</td>
			<td width="160">'.$tax.'</td>
			<td width="120">'.$value['price'].'</td>
			</tr>';
		}

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
			padding: 20px 20px 40px 20px;
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
		<td colspan="2" class="text-right inv-title" style="vertical-align: middle;">'.$data['lang']['quotes']['text_quotation'].'</td>
		</tr>
		<tr class="inv-meta-container">
		<td valign="middle">
		<div class="inv-bill-to">
		<span class="head">'.$data['lang']['quotes']['text_quote_to'].'</span><br />
		<span class="title">'.$result['company'].'</span><br />
		<span class="email">'.$result['email'].'</span><br />
		<span class="body">'.$caddress['address1'].', '.$caddress['address2'].'</span><br />
		<span class="body">'.$caddress['city'].', '.$caddress['state'].'</span><br />
		<span class="body">'.$caddress['country'].'  '.$caddress['pin'].'</span>
		</div>
		</td>
		<td colspan="2" valign="middle" class="text-right">
		<div class="inv-meta">
		<span><span># : </span><span>QTN-'.str_pad($result['id'], 4, '0', STR_PAD_LEFT).'</span></span>
		<p><span>'.$data['lang']['quotes']['text_quote_date'].' : </span><span>'.date_format(date_create($result['date']), 'd-m-Y').'</span></p>
		<p><span>'.$data['lang']['quotes']['text_expiry_date'].' : </span><span>'.date_format(date_create($result['expiry']), 'd-m-Y').'</span></p>
		<p><span>'.$data['lang']['quotes']['text_payment_method'].' : </span><span>'.$result['payment_method'].'</span></p>
		</div>
		</td>
		</tr>
		</tbody>
		</table>
		<div class="inv-template-item">
		<table cellpadding="8">
		<thead>
		<tr style="background-color: #eee;" border="1">
		<th width="280">'.$data['lang']['quotes']['text_item_and_description'].'</th>
		<th width="50">'.$data['lang']['quotes']['text_quantity'].'</th>
		<th width="100">'.$data['lang']['quotes']['text_unit_cost'].'('.$result['currency_abbr'].')</th>
		<th width="160">'.$data['lang']['quotes']['text_tax'].' ('.$result['currency_abbr'].')</th>
		<th width="120">'.$data['lang']['quotes']['text_price'].' ('.$result['currency_abbr'].')</th>
		</tr>
		</thead>
		<tbody>
		'.$item.'
		<tr class="total">
		<td width="330" rowspan="4" colspan="3" valign="bottom">'.$result['note'].'</td>
		<td width="180" colspan="2" align="right">Sub Total</td>
		<td width="200" colspan="2">'.$result['currency_abbr'].' '.$total['subtotal'].'</td>
		</tr>
		<tr class="total">
		<td width="180" colspan="2" align="right">Tax</td>
		<td width="200" colspan="2">'.$result['currency_abbr'].' '.$total['tax'].'</td>
		</tr>
		<tr class="total">
		<td width="180" colspan="2" align="right">Discount (Flat)</td>
		<td width="200" colspan="2">'.$result['currency_abbr'].' '.$total['discount_value'].'</td>
		</tr>
		<tr class="total">
		<td width="180" colspan="2" align="right">Total</td>
		<td width="200" colspan="2">'.$result['currency_abbr'].' '.$total['amount'].'</td>
		</tr>
		<tr>
		<td colspan="8">
		<p class="font-12">'.$data['lang']['quotes']['text_terms_Conditions'].'</p>
		<p class="font-16">'.$result['tc'].'</p>
		</td>
		</tr>
		</tbody>
		</table>
		</div>
		</div>
		</div>';

		return array('html' => $html, 'info' => $info);
	}
}
