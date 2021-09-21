<?php
/**
* RecurringController
*/
use Dompdf\Dompdf;
use Dompdf\Options;
class RecurringController extends Controller
{
	private $invoiceModel;
	function __construct()
	{
		parent::__construct();
		$this->commons = new CommonsController();
		/*Intilize User model*/
		$this->invoiceModel = new Invoice();
	}

	public function index()
	{
		if (!$this->commons->hasPermission('recurring')) {
			Not_foundController::show('403');
			exit();
		}
		/*Get User name and role*/
		$data = $this->commons->getUser();
		
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
			$data['result'] = $this->invoiceModel->getRecurringInvoices($user);
		} else {
			$data['result'] = $this->invoiceModel->getRecurringInvoices();
		}

		/* Set page title */
		$data['page_title'] = $data['lang']['common']['text_recurring_invoices'];
		
		/*Render User list view*/
		$this->view->render('invoice/recurring_invoice_list.tpl', $data);
	}
	/**
	* Invoice index view method
	* This method will be called on Invoice view
	**/
	public function indexView()
	{
		if (!$this->commons->hasPermission('recurring/view')) {
			Not_foundController::show('403');
			exit();
		}
		/**
		* Check if id exist in url if not exist then redirect to Invoice list view 
		**/
		$id = (int)$this->url->get('id');
		if (empty($id) || !is_int($id)) {
			$this->url->redirect('recurring');
		}
		/*Get User name and role*/
		$data = $this->commons->getUser();
		/**
		* Get all User data from DB using Invoice model 
		**/

		if ($user = $this->commons->checkUser()) {
			$data['result'] = $this->invoiceModel->getRecurringInoviceView($id, $user);
		} else {
			$data['result'] = $this->invoiceModel->getRecurringInoviceView($id);
		}

		if (empty($data['result'])) {
			$this->url->redirect('recurring');
		}


		$data['result']['address'] = json_decode($data['result']['address'], true);
		$data['result']['items'] = json_decode($data['result']['items'], true);
		$data['recurringInvoices'] = $this->invoiceModel->getInvoicesCreatedfromRecurring($id);

		$data['taxes'] = $this->invoiceModel->getTaxes();
		$data['payment_type'] = $this->invoiceModel->paymentType();

		$data['info']['address'] = json_decode($data['info']['address'], true);
		$data['info']['invoice_setting'] = json_decode($data['info']['invoice_setting'], true);

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
		$data['page_title'] = $data['lang']['invoices']['text_recurring_invoice_view'];
		$data['action'] = URL.DIR_ROUTE.'invoicePayment/action';
		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);
		
		/*Render User list view*/
		$this->view->render('invoice/recurring_invoice_view.tpl', $data);
	}
	/**
	* Invoice index print method
	* This method will be called on Invoice print
	**/
	public function indexPrint()
	{
		if (!$this->commons->hasPermission('recurring/view')) {
			Not_foundController::show('403');
			exit();
		}
		/**
		* Check if id exist in url if not exist then redirect to Invoice list view 
		**/
		$id = (int)$this->url->get('id');
		if (empty($id) || !is_int($id)) {
			$this->url->redirect('recurring');
		}
		$this->createPDF($id, 1);
	}
	/**
	* Invoice index ADD method
	* This method will be called on add Invoice
	**/
	public function indexAdd()
	{
		if (!$this->commons->hasPermission('recurring/add')) {
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
		$data['page_title'] = $data['lang']['invoices']['text_new_recurring_invoice'];
		$data['action'] = URL.DIR_ROUTE.'recurring/action';
		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);

		/*Render Invoice list view*/
		$this->view->render('invoice/recurring_invoice_form.tpl', $data);
	}
	/**
	* Invoice index edit method
	* This method will be called on edit Invoice
	**/
	public function indexEdit()
	{
		if (!$this->commons->hasPermission('recurring/edit')) {
			Not_foundController::show('403');
			exit();
		}
		/**
		* Check if id exist in url if not exist then redirect to Item list view 
		**/
		$id = (int)$this->url->get('id');
		if (empty($id) || !is_int($id)) {
			$this->url->redirect('recurring');
		}
		/*Get User name and role*/
		$data = $this->commons->getUser();
		/**
		* Get all User data from DB using User model 
		**/
		if ($user = $this->commons->checkUser()) {
			$data['user']['user_id'] = $this->session->data['user_id'];
			$data['admin'] = false;
			$data['result'] = $this->invoiceModel->getRecurringInvoice($id, $user);
			$data['customers'] = $this->invoiceModel->getCustomers($user);
		} else {
			$data['admin'] = true;
			$data['result'] = $this->invoiceModel->getRecurringInvoice($id);
			$data['customers'] = $this->invoiceModel->getCustomers();
		}

		if (empty($data['result'])) {
			$this->url->redirect('recurring');
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
		$data['page_title'] = $data['lang']['invoices']['text_edit_recurring_invoice'];
		$data['action'] = URL.DIR_ROUTE.'recurring/action';
		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);

		/*Render User list view*/

		$this->view->render('invoice/recurring_invoice_form.tpl', $data);
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
			$this->url->redirect('recurring');
			exit();
		}

		if ($this->commons->validateToken($this->url->post('_token'))) {
			$this->url->redirect('recurring');
		}

		if (!empty($this->url->post('id'))) {
			$data = $this->url->post('invoice');
			$data['id'] = $this->url->post('id');
			$data['inv_date'] = date_format(date_create($data['inv_date']), 'Y-m-d');
			$data['item'] = json_encode($data['item']);
			$data['want_payment'] = isset($data['want_payment']) ? $data['want_payment']: 0;
			$data['want_signature'] = isset($data['want_signature']) ? $data['want_signature']: 0;

			$result = $this->invoiceModel->updateRecurringInvoice($data);
			$this->session->data['message'] = array('alert' => 'success', 'value' => 'Recurring Inovice updated successfully.');
			$this->url->redirect('recurring/edit&id='.$data['id']);
		}
		else {
			$data = $this->url->post('invoice');
			$data['item'] = json_encode($data['item']);
			$data['inv_date'] = date_format(date_create($data['inv_date']), 'Y-m-d');
			$data['want_payment'] = isset($data['want_payment']) ? $data['want_payment']: 0;
			$data['want_signature'] = isset($data['want_signature']) ? $data['want_signature']: 0;

			$result = $this->invoiceModel->createRecurringInvoice($data);
			$this->session->data['message'] = array('alert' => 'success', 'value' => 'Recurring Inovice created successfully.');
			
			$this->url->redirect('recurring/edit&id='.$result);
		}
	}
	/**
	* Invoice index delete method
	* This method will be called on Invoice delete
	**/
	public function indexDelete()
	{
		if (!$this->commons->hasPermission('recurring/delete')) {
			Not_foundController::show('403');
			exit();
		}
		$result = $this->invoiceModel->deleteRecurringInvoice($this->url->post('id'));
		$this->session->data['message'] = array('alert' => 'success', 'value' => 'Recurring Invoice deleted successfully.');
		$this->url->redirect('recurring');
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
		
		$this->createPDF($id);
	}

	public function createPDF($id, $printInvoice = NULL)
	{
		/**
		* Get all User data from DB using Invoice model 
		**/
		if ($user = $this->commons->checkUser()) {
			$result = $this->invoiceModel->getRecurringInoviceView($id, $user);
		} else {
			$result = $this->invoiceModel->getRecurringInoviceView($id);
		}

		if (empty($result)) {
			$this->url->redirect('recurring');
		}

		/*Get User name and role*/
		$data = $this->commons->getUser();

		/*Load Language File*/
		require DIR_BUILDER.'language/'.$data['info']['language'].'/common.php';
		$data['lang']['common'] = $lang;
		require DIR_BUILDER.'language/'.$data['info']['language'].'/invoices.php';
		$data['lang']['invoices'] = $invoices;


		$result['address'] = json_decode($result['address'], true);
		$result['items'] = json_decode($result['items'], true);

		$data['info']['address'] = json_decode($data['info']['address'], true);
		$data['info']['invoice_setting'] = json_decode($data['info']['invoice_setting'], true);
		
		/*Load Language File*/
		require DIR_BUILDER.'language/'.$data['info']['language'].'/common.php';
		$data['lang']['common'] = $lang;
		require DIR_BUILDER.'language/'.$data['info']['language'].'/invoices.php';
		$data['lang']['invoices'] = $invoices;

		ob_start();
		include DIR_APP.'views/invoice/recurring_invoice_pdf_'.$data['info']['invoice_setting']['template'].'.tpl.php';
		//exit();
		$html = ob_get_clean();
		ob_end_flush();

		require DIR_BUILDER.'libs/dompdf/autoload.inc.php';

		$dompdf = new Dompdf();


		$dompdf->loadHtml($html);
		// (Optional) Setup the paper size and orientation
		$dompdf->setPaper('letter');
		// Render the HTML as PDF
		$dompdf->render();
		// Output the generated PDF to Browser
		$dompdf->stream("invoice.pdf", array("Attachment" => false));
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
			$this->url->redirect('recurring/view&id='.$data['invoice']);
		}

		if ($this->commons->validateToken($this->url->post('_token'))) {
			$this->url->redirect('recurring/view&id='.$data['invoice']);
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
		$mailer->mail->isHTML(true);
		$mailer->mail->Subject = $data['subject'];
		$mailer->mail->Body = html_entity_decode($data['message']);
		$mailer->mail->AltBody = 'Hello Dear,
		Your Invoice has been created. Invoice Number - RINV-'.str_pad($data['invoice'], 4, '0', STR_PAD_LEFT).'
		You can also view this invoice online by clicking here.
		Thank you,
		Administrator';
		$mailer->sendMail();
		$this->session->data['message'] = array('alert' => 'success', 'value' => 'Email Sent successfully.');
		
		$this->url->redirect('recurring/view&id='.$data['invoice']);
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