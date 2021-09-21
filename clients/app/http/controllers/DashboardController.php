<?php

/**
* Dashboard Controller
*/
class DashboardController extends Controller
{
	/**
	* Private Department model variable
	* This will be used for calling department model's function
	**/
	private $dashboardModel;
	/*Class Constructor*/
	function __construct()
	{
		/*Call parent constructor*/
		parent::__construct();
		$this->commons = new CommonsController();
		/*Intilize dashboard model*/
		$this->dashboardModel = new Dashboard();
	}

	/**
	* Dasboard index method
	* This method will be called on dahsboard view
	**/
	public function index()
	{
		$customer = $this->session->data['customer'];
		$data = $this->commons->getUser();

		/*Load Language File*/
		require DIR_BUILDER.'language/'.$data['info']['language'].'/common.php';
		$data['lang']['common'] = $lang;
		require DIR_BUILDER.'language/'.$data['info']['language'].'/dashboard.php';
		$data['lang']['dashboard'] = $dashboard;

		$invoice_status = $this->dashboardModel->invoiceStatus($customer);

		if (empty($invoice_status)) {
			$data['invoice_status']['value'] = 0;
			$data['invoice_status']['label'] = 'No Invoice Found';
			$data['invoice_status'] = json_encode($data['invoice_status']);
		} else {
			foreach ($invoice_status as $key => $value) {
				if ($value['label'] == "Paid") 
				{
					$invoice_status[$key]['label'] = $data['lang']['dashboard']['text_paid']; 
				} elseif ($value['label'] == "Unpaid") { 
					$invoice_status[$key]['label'] = $data['lang']['dashboard']['text_unpaid']; 
				} elseif ($value['label'] == "Pending") { 
					$invoice_status[$key]['label'] = $data['lang']['dashboard']['text_pending'];
				} elseif ($value['label'] == "In Process") {
					$invoice_status[$key]['label'] = $data['lang']['dashboard']['text_in_process']; 
				} elseif ($value['label'] == "Cancelled") {
					$invoice_status[$key]['label'] = $data['lang']['dashboard']['text_cancelled']; 
				} elseif ($value['label'] == "Other") {
					$invoice_status[$key]['label'] = $data['lang']['dashboard']['text_other']; 
				} elseif ($value['label'] == "Partially Paid") { 
					$invoice_status[$key]['label'] = $data['lang']['dashboard']['text_partially_paid']; 
				} else { 
					$invoice_status[$key]['label'] = $data['lang']['dashboard']['text_unknown']; 
				}
			}
			$data['invoice_status'] = json_encode($invoice_status);
		}

		$ticket_status = $this->dashboardModel->ticketStatus($data['user']['email']);
		if (empty($ticket_status)) {
			$data['ticket_status']['value'] = 0;
			$data['ticket_status']['label'] = 'No Invoice Found';
			$data['ticket_status'] = json_encode($data['ticket_status']);
		} else {
			foreach ($ticket_status as $key => $value) {
				if ($value['label'] == "Open") 
				{
					$ticket_status[$key]['label'] = $data['lang']['dashboard']['text_open']; 
				} else { 
					$ticket_status[$key]['label'] = $data['lang']['dashboard']['text_closed']; 
				}
			}
			$data['ticket_status'] = json_encode($ticket_status);
		}

		$data['lastticket'] = $this->dashboardModel->getLastTicket($data['user']['email']);

		$data['countInvoice'] = $this->dashboardModel->invoiceCount($customer);
		$data['countQuotes'] = $this->dashboardModel->quotesCount($customer);
		$data['countTicket'] = $this->dashboardModel->ticketCount($data['user']['email']);

		$data['invoices'] = $this->dashboardModel->getInvoices($customer);
		$data['quotes'] = $this->dashboardModel->getQuotes($customer);
		

		/*Render dahsboard view*/
		$this->view->render('dashboard/dashboard.tpl', $data);
	}
}