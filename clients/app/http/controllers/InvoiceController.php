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
	* Contact index method
	* This method will be called on Contact list view
	**/
	public function index()
	{
		
		$customer = $this->session->data['customer'];

		/**
		* Get all User data from DB using User model 
		**/

		$data = $this->commons->getUser();

		if (!empty($customer)) {
			$data['result'] = $this->invoiceModel->getInvoices($customer);
		} else {
			$data['result'] = NULL;
		}

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

		/* Set page title */
		$data['page_title'] = $data['lang']['common']['text_invoices'];
		
		/*Render User list view*/
		$this->view->render('invoice/invoice_list.tpl', $data);
	}

	public function indexView()
	{
		$data = $this->commons->getUser();
		/**
		* Check if id exist in url if not exist then redirect to Invoice list view 
		**/
		$data['id'] = (int)$this->url->get('id');
		if (empty($data['id']) || !is_int($data['id'])) { $this->url->redirect('invoices'); }

		/*Load Language File*/
		require DIR_BUILDER.'language/'.$data['info']['language'].'/common.php';
		$data['lang']['common'] = $lang;
		require DIR_BUILDER.'language/'.$data['info']['language'].'/invoices.php';
		$data['lang']['invoices'] = $invoices;

		$data['customer'] = $this->session->data['customer'];
		if (empty($data['customer'])) {
			$this->url->redirect('invoices');
		}

		$data['result'] = $this->invoiceModel->getInoviceView($data);
		if (empty($data['result'])) { $this->url->redirect('invoices'); }

		$data['payments'] = $this->invoiceModel->getPayments($data['id']);
		$data['attachments'] = $this->invoiceModel->getAttachments($data['id']);
		
		$data['result']['address'] = json_decode($data['result']['address'], true);
		$data['result']['items'] = json_decode($data['result']['items'], true);
		$data['info']['address'] = json_decode($data['info']['address'], true);
		$data['info']['invoice_setting'] = json_decode($data['info']['invoice_setting'], true);
		
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
		$data['action'] = URL_CLIENTS.DIR_ROUTE.'invoicePayment/action';
		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);
		
		/*Render User list view*/
		$this->view->render('invoice/invoice_view.tpl', $data);
	}

	public function indexPrint()
	{
		/**
		* Check if id exist in url if not exist then redirect to Invoice list view 
		**/
		$id = (int)$this->url->get('id');
		if (empty($id) || !is_int($id)) { $this->url->redirect('invoices'); }
		$this->createPDFHTML($id, 1);
	}

	public function indexPdf()
	{
		/**
		* Check if id exist in url if not exist then redirect to Invoice list view 
		**/
		$id = (int)$this->url->get('id');
		if (empty($id) || !is_int($id)) { $this->url->redirect('invoices');}
		$this->createPDFHTML($id);
	}

	public function createPDFHTML($id, $printInvoice = NULL)
	{
		$data = $this->commons->getUser();
		$data['id'] = $id;
		$data['customer'] = $this->session->data['customer'];
		if (empty($data['customer'])) { $this->url->redirect('invoices'); }

		$result = $this->invoiceModel->getInoviceView($data);
		if (empty($result)) { $this->url->redirect('invoices'); }

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
		include DIR_APP.'views/invoice/invoice_pdf_'.$data['info']['invoice_setting']['template'].'.tpl.php';
		$html = ob_get_clean();
		ob_end_flush();
		
		require DIR_BUILDER.'libs/dompdf/autoload.inc.php';
		
		$dompdf = new Dompdf();
		$dompdf->loadHtml($html);
		$dompdf->setPaper('letter');
		$dompdf->render();
		$dompdf->stream("invoice.pdf", array("Attachment" => false));
	}
}