<?php

/**
* Dashboard Controller
*/
class DashboardController extends Controller
{
	/**
	* Private Dashboard model variable
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
		/*Get Logged in user info*/
		$data = $this->commons->getUser();
		/*Load Language File*/
		require DIR_BUILDER.'language/'.$data['info']['language'].'/common.php';
		$data['lang']['common'] = $lang;
		require DIR_BUILDER.'language/'.$data['info']['language'].'/dashboard.php';
		$data['lang']['dashboard'] = $dashboard;
		
		/*Get all Expenses*/
		$data['expenses'] = json_encode($this->dashboardModel->getExpenses());
		/*Get income and expenses stats*/
		$data['stats'] = json_encode($this->dashboardModel->getIncomeExpenses());

		if ($user = $this->commons->checkUser()) {
			/*Get latest contact*/
			$data['contacts'] = $this->dashboardModel->getLatestContact($user);
			/*Get latest invoices*/
			$data['invoices'] = $this->dashboardModel->getLatestInvoice($user);
		} else {
			/*Get latest contact*/
			$data['contacts'] = $this->dashboardModel->getLatestContact();
			/*Get latest invoices*/
			$data['invoices'] = $this->dashboardModel->getLatestInvoice();
		}

		/*Get Invoice by status */
		$data['invoiceByStatus'] = $this->dashboardModel->getInvoiceByStatus();
		if (!empty($data['invoiceByStatus'])) {
			foreach ($data['invoiceByStatus'] as $key => $value) {
				if ($value['label'] == "Paid") 
				{
					$data['invoiceByStatus'][$key]['label'] = $data['lang']['dashboard']['text_paid']; 
				} elseif ($value['label'] == "Unpaid") { 
					$data['invoiceByStatus'][$key]['label'] = $data['lang']['dashboard']['text_unpaid']; 
				} elseif ($value['label'] == "Pending") { 
					$data['invoiceByStatus'][$key]['label'] = $data['lang']['dashboard']['text_pending'];
				} elseif ($value['label'] == "In Process") {
					$data['invoiceByStatus'][$key]['label'] = $data['lang']['dashboard']['text_in_process']; 
				} elseif ($value['label'] == "Cancelled") {
					$data['invoiceByStatus'][$key]['label'] = $data['lang']['dashboard']['text_cancelled']; 
				} elseif ($value['label'] == "Other") {
					$data['invoiceByStatus'][$key]['label'] = $data['lang']['dashboard']['text_other']; 
				} elseif ($value['label'] == "Partially Paid") { 
					$data['invoiceByStatus'][$key]['label'] = $data['lang']['dashboard']['text_partially_paid']; 
				} else { 
					$data['invoiceByStatus'][$key]['label'] = $data['lang']['dashboard']['text_unknown']; 
				}
			}
		}
		$data['invoiceByStatus'] = json_encode($data['invoiceByStatus']);

		/*Get Ticket by status */
		$data['ticketByStatus'] = $this->dashboardModel->getTicketByStatus();
		if (!empty($data['ticketByStatus'])) {
			foreach ($data['ticketByStatus'] as $key => $value) {
				if ($value['label'] == "Open") 
				{
					$data['ticketByStatus'][$key]['label'] = $data['lang']['dashboard']['text_open']; 
				} else { 
					$data['ticketByStatus'][$key]['label'] = $data['lang']['dashboard']['text_closed']; 
				}
			}
		}
		$data['ticketByStatus'] = json_encode($data['ticketByStatus']);

		/*Get recent list*/
		$data['recents'] = $this->dashboardModel->getRecentlyAdded();
		/*Get total Statistics*/
		$data['statistics'] = $this->dashboardModel->getStatistics();
		/*Render dahsboard view*/
		$this->view->render('dashboard/dashboard.tpl', $data);
	}

	public function convetInvoiceLanguage($data)
	{
		
	}
}