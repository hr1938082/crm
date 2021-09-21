<?php
/**
* QuoteController
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
	
	public function index()
	{
		$customer = $this->session->data['customer'];

		$data = $this->commons->getUser();

		if (!empty($customer)) {
			$data['result'] = $this->quoteModel->getQuotes($customer);
		} else {
			$data['result'] = NULL;
		}
		/*Load Language File*/
		require DIR_BUILDER.'language/'.$data['info']['language'].'/common.php';
		$data['lang']['common'] = $lang;
		require DIR_BUILDER.'language/'.$data['info']['language'].'/quotes.php';
		$data['lang']['quotes'] = $quotes;

		/* Set page title */
		$data['page_title'] = $data['lang']['common']['text_quotations'];
		/*Render User list view*/
		$this->view->render('quote/quote_list.tpl', $data);
	}
	
	public function indexView()
	{
		/**
		* Check if id exist in url if not exist then redirect to Invoice list view 
		**/
		$data = $this->commons->getUser();

		$data['id'] = (int)$this->url->get('id');
		if (empty($data['id']) || !is_int($data['id'])) {
			$this->url->redirect('quotes');
		}

		$data['customer'] = $this->session->data['customer'];
		if (empty($data['customer'])) { $this->url->redirect('quotes'); }
		
		/*Load Language File*/
		require DIR_BUILDER.'language/'.$data['info']['language'].'/common.php';
		$data['lang']['common'] = $lang;
		require DIR_BUILDER.'language/'.$data['info']['language'].'/quotes.php';
		$data['lang']['quotes'] = $quotes;

		$data['result'] = $this->quoteModel->getQuoteView($data);
		
		if (empty($data['result'])) { $this->url->redirect('quotes'); }
		
		$data['result']['address'] = json_decode($data['result']['address'], true);
		$data['result']['items'] = json_decode($data['result']['items'], true);
		$data['result']['total'] = json_decode($data['result']['total'], true);
		$data['info']['address'] = json_decode($data['info']['address'], true);

		/* Set page title */
		$data['page_title'] = $data['lang']['quotes']['text_quotation_view'];
		
		/*Render User list view*/
		$this->view->render('quote/quote_view.tpl', $data);
	}

	public function indexPrint()
	{
		$id = (int)$this->url->get('id');
		if (empty($id) || !is_int($id)) { $this->url->redirect('quotes'); }
		$this->createPDFHTML($id, 1);
	}

	public function indexPdf()
	{
		/**
		* Check if id exist in url if not exist then redirect to Invoice list view 
		**/
		$id = (int)$this->url->get('id');
		if (empty($id) || !is_int($id)) { $this->url->redirect('quotes'); }

		$this->createPDFHTML($id);
	}

	public function createPDFHTML($id, $printQuote = NULL)
	{
		$data = $this->commons->getUser();
		$data['id'] = $id;
		$data['customer'] = $this->session->data['customer'];
		if (empty($data['customer'])) { $this->url->redirect('quotes'); }

		$result = $this->quoteModel->getQuoteView($data);
		if (empty($result)) { $this->url->redirect('quotes'); }

		$result['address'] = json_decode($result['address'], true);
		$result['items'] = json_decode($result['items'], true);
		$result['total'] = json_decode($result['total'], true);
		$data['info']['address'] = json_decode($data['info']['address'], true);
		$data['info']['invoice_setting'] = json_decode($data['info']['invoice_setting'], true);

		/*Load Language File*/
		require DIR_BUILDER.'language/'.$data['info']['language'].'/common.php';
		$data['lang']['common'] = $lang;
		require DIR_BUILDER.'language/'.$data['info']['language'].'/quotes.php';
		$data['lang']['quotes'] = $quotes;
		
		ob_start();
		include DIR_APP.'views/quote/quote_pdf_'.$data['info']['invoice_setting']['template'].'.tpl.php';
		$html = ob_get_clean();
		ob_end_flush();

		require DIR_BUILDER.'libs/dompdf/autoload.inc.php';
		
		$dompdf = new Dompdf();
		$dompdf->loadHtml($html);
		$dompdf->setPaper('letter');
		$dompdf->render();
		$dompdf->stream($data['lang']['quotes']['text_quotation'].".pdf", array("Attachment" => false));
	}

	public function indexAutoInvoice()
	{
		if (!isset($_POST['submit'])) {
			$this->url->redirect('quotes');
			exit();
		}

		$passData['id'] = (int)$this->url->post('id');
		if (empty($passData['id']) || !is_int($passData['id'])) {
			$this->url->redirect('quotes');
		}
		$passData['customer'] = $this->session->data['customer'];
		$data = $this->quoteModel->getQuoteView($passData);
	
		$items = json_decode($data['total'], true);
		$data['subtotal'] = $items['subtotal'];
		$data['tax'] = $items['tax'];
		$data['discounttype'] = $items['discounttype'];
		$data['discount'] = $items['discount'];
		$data['discount_value'] = $items['discount_value'];
		$data['amount'] = $items['amount'];
		$data['paid'] = '0.00';
		$data['due'] = $items['amount'];
		$data['status'] = "Unpaid";
		$data['inv_status'] = 1;
		$data['duedate'] = date_format(date_create(), "Y-m-d");
		$data['paiddate'] = date_format(date_create(), "Y-m-d");

		$result = $this->quoteModel->createQuoteInvoice($data);
		$this->createPDF($result);
		$this->invoiceMail($result);
		$this->session->data['message'] = array('alert' => 'success', 'value' => 'Invoice created successfully.');
		$this->url->redirect('invoice/view&id='.$result);
	}

	public function createPDF($id, $printInvoice = NULL)
	{
		/**
		* Get all User data from DB using Invoice model 
		**/
		$result = $this->quoteModel->getInoviceView($id);
		$result['address'] = json_decode($result['address'], true);
		$result['items'] = json_decode($result['items'], true);
		
		$data = $this->commons->getUser();
		$data['info']['address'] = json_decode($data['info']['address'], true);
		$data['info']['invoice_setting'] = json_decode($data['info']['invoice_setting'], true);

		/*Load Language File*/
		require DIR_BUILDER.'language/'.$data['info']['language'].'/common.php';
		$data['lang']['common'] = $lang;
		require DIR_BUILDER.'language/'.$data['info']['language'].'/invoices.php';
		$data['lang']['invoices'] = $invoices;

		ob_start();
		include DIR_APP.'views/invoice/invoice_pdf_'.$data['info']['invoice_setting']['template'].'.tpl.php';
		$html = ob_get_clean();
		ob_end_flush();

		require DIR_BUILDER.'libs/dompdf/autoload.inc.php';
		$dompdf = new Dompdf();
		$dompdf->loadHtml($html);
		$dompdf->setPaper('letter');
		$dompdf->render();
		$output = $dompdf->output();
		file_put_contents(DIR.'public/uploads/pdf/invoice-'.$id.'.pdf', $output);
	}
	/**
	* Invoice invoice mail method
	* This method will be called on to mail invoice details when adding new invoices
	**/
	private function invoiceMail($id)
	{
		$data = $this->quoteModel->getInoviceView($id);
		$info = $this->quoteModel->getOrganization();
		$data['id'] = str_pad($data['id'], 4, '0', STR_PAD_LEFT);
		$template = $this->quoteModel->getTemplate('newinvoice');
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
		$mailer->mail->setFrom($info['email'], $info['name']);
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