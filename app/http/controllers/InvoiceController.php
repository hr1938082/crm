<?php
/**
* InvoiceController
*/
use Dompdf\Dompdf;
use Dompdf\Options;

class InvoiceController extends Controller 
{
	private $invoiceModel;
	function __construct()
	{
		parent::__construct();
		$this->commons = new CommonsController();
		/*Intilize User model*/
		$this->invoiceModel = new Invoice();
	}
	/**
	* Invoice index method
	* This method will be called on Invoice list view
	**/
	public function index()
	{
		if (!$this->commons->hasPermission('invoices')) {
			Not_foundController::show('403');
			exit();
		}
		/*Get User name and role*/
		$data = $this->commons->getUser();
		/**
		* Get all User data from DB using User model 
		**/
		
		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}

		/*Load Language File*/
		require DIR_BUILDER.'language/'.$data['info']['language'].'/common.php';
		$data['lang']['common'] = $lang;
		require DIR_BUILDER.'language/'.$data['info']['language'].'/invoices.php';
		$data['lang']['invoices'] = $invoices;

		/**
		* Get all User data from DB using User model 
		**/
		if ($user = $this->commons->checkUser()) {
			$data['result'] = $this->invoiceModel->getInvoices($user);
		} else {
			$data['result'] = $this->invoiceModel->getInvoices();
		}

		/* Set page title */
		$data['page_title'] = $data['lang']['common']['text_invoices'];
		
		/*Render User list view*/
		$this->view->render('invoice/invoice_list.tpl', $data);
	}
	/**
	* Invoice index view method
	* This method will be called on Invoice view
	**/
	public function indexView()
	{
		if (!$this->commons->hasPermission('invoice/view')) {
			Not_foundController::show('403');
			exit();
		}
		/**
		* Check if id exist in url if not exist then redirect to Invoice list view 
		**/
		$id = (int)$this->url->get('id');
		if (empty($id) || !is_int($id)) {
			$this->url->redirect('invoices');
		}
		/*Get User name and role*/
		$data = $this->commons->getUser();
		/**
		* Get all User data from DB using Invoice model 
		**/
		if ($user = $this->commons->checkUser()) {
			$data['result'] = $this->invoiceModel->getInoviceView($id, $user);
		} else {
			$data['result'] = $this->invoiceModel->getInoviceView($id);
		}

		if (empty($data['result'])) {
			$this->url->redirect('invoices');
		}
		$data['taxes'] = $this->invoiceModel->getTaxes();
		$data['payment_type'] = $this->invoiceModel->paymentType();
		$data['payments'] = $this->invoiceModel->getPayments($id);
		$data['attachments'] = $this->invoiceModel->getAttachments($id);
		
		$data['info']['address'] = json_decode($data['info']['address'], true);
		$data['info']['invoice_setting'] = json_decode($data['info']['invoice_setting'], true);
		$data['result']['address'] = json_decode($data['result']['address'], true);
		$data['result']['items'] = json_decode($data['result']['items'], true);

		/*Load Language File*/
		require DIR_BUILDER.'language/'.$data['info']['language'].'/common.php';
		$data['lang']['common'] = $lang;
		require DIR_BUILDER.'language/'.$data['info']['language'].'/invoices.php';
		$data['lang']['invoices'] = $invoices;

		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}
		/**
		* Get all User data from DB using Invoice model 
		**/
		/* Set page title */
		$data['page_title'] = $data['lang']['invoices']['text_invoice_view'];
		$data['action'] = URL.DIR_ROUTE.'invoicePayment/action';
		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);
		
		/*Render User list view*/
		$this->view->render('invoice/invoice_view.tpl', $data);
	}
	/**
	* Invoice index print method
	* This method will be called on Invoice print
	**/
	public function indexPrint()
	{
		if (!$this->commons->hasPermission('invoice/view')) {
			Not_foundController::show('403');
			exit();
		}
		/**
		* Check if id exist in url if not exist then redirect to Invoice list view 
		**/
		$id = (int)$this->url->get('id');
		if (empty($id) || !is_int($id)) {
			$this->url->redirect('invoices');
		}

		$html_array = $this->createPDFHTML($id, 1);
		require DIR_BUILDER.'libs/dompdf/autoload.inc.php';
		//$_dompdf_show_warnings = true;
		//$_dompdf_warnings = [];
		$dompdf = new Dompdf();
		$dompdf->loadHtml($html_array['html']);
		// (Optional) Setup the paper size and orientation
		$dompdf->setPaper('letter');
		// Render the HTML as PDF
		$dompdf->render();
		// Output the generated PDF to Browser
		$dompdf->stream("invoice.pdf", array("Attachment" => false));
	}

	/**
	* Invoice index ADD method
	* This method will be called on add Invoice
	**/
	public function indexAdd()
	{
		if (!$this->commons->hasPermission('invoice/add')) {
			Not_foundController::show('403');
			exit();
		}
		/*Get User name and role*/
		$data = $this->commons->getUser();
		$data['info']['invoice_setting'] = json_decode($data['info']['invoice_setting'], true);
		/**
		* Get all User data from DB using Invoice model 
		**/
		if ($user = $this->commons->checkUser()) {
			$data['user']['user_id'] = $this->session->data['user_id'];
			$data['admin'] = false;
			$data['customers'] = $this->invoiceModel->getCustomers($user);
		} else {
			$data['admin'] = true;
			$data['customers'] = $this->invoiceModel->getCustomers();
		}
		$data['result'] = NULL;
		$data['payment_type'] = $this->invoiceModel->paymentType();
		$data['taxes'] = $this->invoiceModel->getTaxes();
		$data['items'] = $this->invoiceModel->getItems();
		$data['currency'] = $this->invoiceModel->getCurrency();

		/*Load Language File*/
		require DIR_BUILDER.'language/'.$data['info']['language'].'/common.php';
		$data['lang']['common'] = $lang;
		require DIR_BUILDER.'language/'.$data['info']['language'].'/invoices.php';
		$data['lang']['invoices'] = $invoices;

		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}
		/* Set page title */
		$data['page_title'] = $data['lang']['invoices']['text_new_invoice'];
		$data['action'] = URL.DIR_ROUTE.'invoice/action';
		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);
		
		/*Render Invoice list view*/
		$this->view->render('invoice/invoice_form.tpl', $data);
	}
	/**
	* Invoice index edit method
	* This method will be called on edit Invoice
	**/
	public function indexEdit()
	{
		if (!$this->commons->hasPermission('invoice/edit')) {
			Not_foundController::show('403');
			exit();
		}
		/**
		* Check if id exist in url if not exist then redirect to Item list view 
		**/
		$id = (int)$this->url->get('id');
		if (empty($id) || !is_int($id)) {
			$this->url->redirect('invoices');
		}
		/*Get User name and role*/
		$data = $this->commons->getUser();
		/**
		* Get all User data from DB using User model 
		**/
		if ($user = $this->commons->checkUser()) {
			$data['user']['user_id'] = $this->session->data['user_id'];
			$data['admin'] = false;
			$data['result'] = $this->invoiceModel->getInovice($id, $user);
			$data['customers'] = $this->invoiceModel->getCustomers($user);
		} else {
			$data['admin'] = true;
			$data['result'] = $this->invoiceModel->getInovice($id);
			$data['customers'] = $this->invoiceModel->getCustomers();
		}

		if (empty($data['result'])) {
			$this->url->redirect('invoices');
		}

		$data['payment_type'] = $this->invoiceModel->paymentType();
		$data['taxes'] = $this->invoiceModel->getTaxes();
		$data['items'] = $this->invoiceModel->getItems();
		$data['currency'] = $this->invoiceModel->getCurrency();

		/*Load Language File*/
		require DIR_BUILDER.'language/'.$data['info']['language'].'/common.php';
		$data['lang']['common'] = $lang;
		require DIR_BUILDER.'language/'.$data['info']['language'].'/invoices.php';
		$data['lang']['invoices'] = $invoices;

		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}
		/* Set page title */
		$data['page_title'] = $data['lang']['invoices']['text_edit_invoice'];
		$data['action'] = URL.DIR_ROUTE.'invoice/action';
		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);

		/*Render User list view*/
		$this->view->render('invoice/invoice_form.tpl', $data);
	}
	/**
	* Invoice index action or submit method
	* This method will be called on Invoice save
	**/
	public function indexAction()
	{
		/**
		* Check if from is submitted or not 
		**/
		if (!isset($_POST['submit'])) {
			$this->url->redirect('invoices');
			exit();
		}

		if ($this->commons->validateToken($this->url->post('_token'))) {
			$this->url->redirect('invoices');
		}

		if (!empty($this->url->post('id'))) {
			$data = $this->url->post('invoice');
			$data['id'] = $this->url->post('id');
			$data['item'] = json_encode($data['item']);
			$data['duedate'] = date_format(date_create($data['duedate']), 'Y-m-d');
			$data['paiddate'] = date_format(date_create($data['paiddate']), 'Y-m-d');
			$data['want_payment'] = isset($data['want_payment']) ? $data['want_payment']: 0;
			$data['want_signature'] = isset($data['want_signature']) ? $data['want_signature']: 0;

			$result = $this->invoiceModel->updateInvoice($data);
			$this->session->data['message'] = array('alert' => 'success', 'value' => 'Inovice updated successfully.');
			$this->createPDF($data['id']);
			$this->url->redirect('invoice/view&id='.$data['id']);
		}
		else {
			$data = $this->url->post('invoice');
			$data['item'] = json_encode($data['item']);
			$data['duedate'] = date_format(date_create($data['duedate']), "Y-m-d");
			$data['paiddate'] = date_format(date_create($data['paiddate']), "Y-m-d");
			$data['want_payment'] = isset($data['want_payment']) ? $data['want_payment']: 0;
			$data['want_signature'] = isset($data['want_signature']) ? $data['want_signature']: 0;
			$result = $this->invoiceModel->createInvoice($data);
			$this->createPDF($result);
			if ($data['inv_status'] == "1") {
				$this->invoiceMail($result);
			}
			$this->session->data['message'] = array('alert' => 'success', 'value' => 'Inovice created successfully.');
			$this->url->redirect('invoice/view&id='.$result);
		}
	}
	/**
	* Quotes index auto invoice method
	* This method will be called to convert quotes to invoice
	**/
	public function indexAutoInvoice()
	{
		/**
		* Check if id exist in url if not exist then redirect to Item list view 
		**/
		$id = (int)$this->url->get('id');
		if (empty($id) || !is_int($id)) {
			$this->url->redirect('quotes');
		}

		$data = $this->invoiceModel->getQuoteView($id);

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
		$data['duedate'] = date_format(date_create(), "Y-m-d");
		$data['paiddate'] = date_format(date_create(), "Y-m-d");
		
		$result = $this->invoiceModel->createQuoteInvoice($data);
		$this->createPDF($result);
		$this->invoiceMail($result);
		$this->session->data['message'] = array('alert' => 'success', 'value' => 'Invoice created successfully.');
		$this->url->redirect('invoice/view&id='.$result);
	}
	/**
	* Invoice index delete method
	* This method will be called on Invoice delete
	**/
	public function indexDelete()
	{
		if (!$this->commons->hasPermission('invoice/delete')) {
			Not_foundController::show('403');
			exit();
		}
		$result = $this->invoiceModel->deleteInvoice($this->url->post('id'));
		$this->session->data['message'] = array('alert' => 'success', 'value' => 'Invoice deleted successfully.');
		$this->url->redirect('invoices');
	}
	/**
	* Invoice invoice mail method
	* This method will be called on to mail invoice details when adding new invoices
	**/
	private function invoiceMail($id)
	{
		$data = $this->invoiceModel->getInoviceView($id);
		$info = $this->invoiceModel->getOrganization();

		$data['id'] = str_pad($data['id'], 4, '0', STR_PAD_LEFT);
		$template = $this->invoiceModel->getTemplate('newinvoice');
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
	/**
	* Invoice index PDF method
	* This method will be called to create PDF
	**/
	public function indexPdf()
	{
		/**
		* Check if id exist in url if not exist then redirect to Invoice list view 
		**/
		$id = (int)$this->url->get('id');
		if (empty($id) || !is_int($id)) {
			$this->url->redirect('invoices');
		}

		$html_array = $this->createPDFHTML($id);
		require DIR_BUILDER.'libs/dompdf/autoload.inc.php';
		//$_dompdf_show_warnings = true;
		//$_dompdf_warnings = [];
		$dompdf = new Dompdf();
		$dompdf->loadHtml($html_array['html']);
		// (Optional) Setup the paper size and orientation
		$dompdf->setPaper('letter');
		// Render the HTML as PDF
		$dompdf->render();
		// Output the generated PDF to Browser
		$dompdf->stream("invoice.pdf", array("Attachment" => false));
	}

	public function indexItems()
	{
		$data = $this->invoiceModel->getItems();
		echo json_encode($data);
	}

	public function createPDF($id)
	{
		$html_array = $this->createPDFHTML($id);
		require DIR_BUILDER.'libs/dompdf/autoload.inc.php';
		
		$dompdf = new Dompdf();
		$dompdf->loadHtml($html_array['html']);
		// (Optional) Setup the paper size and orientation
		$dompdf->setPaper('letter');
		// Render the HTML as PDF
		$dompdf->render();
		// Output the generated PDF to Browser
		$output = $dompdf->output();
		file_put_contents(DIR.'public/uploads/pdf/invoice-'.$id.'.pdf', $output);
	}

	private function createPDFHTML($id, $printInvoice = NULL)
	{
		/**
		* Get all User data from DB using Invoice model 
		**/
		if ($user = $this->commons->checkUser()) {
			$result = $this->invoiceModel->getInoviceView($id, $user);
		} else {
			$result = $this->invoiceModel->getInoviceView($id);
		}

		if (empty($result)) { $this->url->redirect('invoices'); }

		$result['address'] = json_decode($result['address'], true);
		$result['items'] = json_decode($result['items'], true);

		/*Get User name and role*/
		$data = $this->commons->getUser();
		$data['info']['address'] = json_decode($data['info']['address'], true);
		$data['info']['invoice_setting'] = json_decode($data['info']['invoice_setting'], true);
		
		/*Load Language File*/
		require DIR_BUILDER.'language/'.$data['info']['language'].'/common.php';
		$data['lang']['common'] = $lang;
		require DIR_BUILDER.'language/'.$data['info']['language'].'/invoices.php';
		$data['lang']['invoices'] = $invoices;

		if ($result['status'] == "Paid") {$result['status'] = $data['lang']['invoices']['text_paid'];}
		elseif ($result['status'] == "Unpaid") {$result['status'] = $data['lang']['invoices']['text_unpaid'];}
		elseif ($result['status'] == "Pending") {$result['status'] = $data['lang']['invoices']['text_pending'];}
		elseif ($result['status'] == "In Process") {$result['status'] = $data['lang']['invoices']['text_in_process']; }
		elseif ($result['status'] == "Cancelled") {$result['status'] = $data['lang']['invoices']['text_cancelled'];}
		elseif ($result['status'] == "Other") {$result['status'] = $data['lang']['invoices']['text_other'];}
		elseif ($result['status'] == "Partially Paid") {$result['status'] = $data['lang']['invoices']['text_partially_paid'];}
		else {$result['status'] = $data['lang']['invoices']['text_unknown'];}

		ob_start();
		include DIR_APP.'views/invoice/invoice_pdf_'.$data['info']['invoice_setting']['template'].'.tpl.php';
		$html = ob_get_clean();
		ob_end_flush();
		
		return array('html' => $html, 'info' => $data['info']);
	}

	/**
	* Invoice index mail method
	* This method will be called to maiil invoice reminder etc
	**/
	public function indexMail()
	{
		$data = $this->url->post('mail');

		if ($validate_field = $this->vaildateMailField($data)) {
			$this->session->data['message'] = array('alert' => 'error', 'value' => 'Please enter valid '.implode(", ",$validate_field).'!');
			$this->url->redirect('invoice/view&id='.$data['invoice']);
		}

		if ($this->commons->validateToken($this->url->post('_token'))) {
			$this->url->redirect('invoice/view&id='.$data['invoice']);
		}

		$info = $this->invoiceModel->getOrganization();

		$mailer = new Mailer();
		$useornot = $mailer->getData();
		if (!$useornot) {
			$mailer->mail->setFrom($info['email'], $info['name']);
		}

		$mailer->mail->addAddress($data['to'], $data['name']);
		if (!empty($data['bcc'])) {
			$mailer->mail->addBCC($data['bcc'], $data['bcc']);
		}
		if (isset($data['attachPdf']) && $data['attachPdf'] == "1") {
			$mailer->mail->addAttachment(DIR.'public/uploads/pdf/invoice-'.$data['invoice'].'.pdf','Invoice.pdf');
		}

		$mailer->mail->isHTML(true);
		$mailer->mail->Subject = $data['subject'];
		$mailer->mail->Body = html_entity_decode($data['message']);
		$mailer->mail->AltBody = 'Hello Dear,
		Your Invoice has been created. Invoice Number - INV-'.str_pad($data['invoice'], 4, '0', STR_PAD_LEFT).'
		You can also view this invoice online by clicking here.
		Thank you,
		Administrator';
		$mailer->sendMail();
		$data['type'] = "invoice";
		$data['type_id'] = $data['invoice'];
		$data['user_id'] = $this->session->data['user_id'];

		$this->invoiceModel->emailLog($data);
		$this->session->data['message'] = array('alert' => 'success', 'value' => 'Email Sent successfully.');
		
		$this->url->redirect('invoice/view&id='.$data['invoice']);
	}
	/**
	* Validate Field Method
	* This method will be called on to validate invoice field
	**/
	private function vaildateMailField($data)
	{
		$error = [];
		$error_flag = false;

		if ($this->commons->validateText($data['to'])) {
			$error_flag = true;
			$error['to'] = 'Email!';
		}

		if ($this->commons->validateText($data['subject'])) {
			$error_flag = true;
			$error['subject'] = 'Subject!';
		}

		if ($this->commons->validateText($data['message'])) {
			$error_flag = true;
			$error['message'] = 'Message!';
		}
		
		if ($error_flag) {
			return $error;
		} else {
			return false;
		}
	}
}