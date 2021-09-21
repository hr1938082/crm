<?php

/**
* TaxController
*/
class TaxController extends Controller
{
	private $taxModel;
	function __construct()
	{
		parent::__construct();
		$this->commons = new CommonsController();
		/*Intilize User model*/
		$this->taxModel = new Tax();
	}
	/**
	* Contact index method
	* This method will be called on Contact list view
	**/
	public function index()
	{
		$this->commons->isAdmin();
		
		/*Get User name and role*/
		$data = $this->commons->getUser();

		/*Load Language File*/
		require DIR_BUILDER.'language/'.$data['info']['language'].'/common.php';
		$data['lang']['common'] = $lang;
		require DIR_BUILDER.'language/'.$data['info']['language'].'/settings.php';
		$data['lang']['settings'] = $settings;

		/**
		* Get all Tax data from DB using Tax model 
		**/
		$data['result'] = $this->taxModel->getTaxes();
		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}
		/* Set page title */
		$data['page_title'] = $data['lang']['settings']['text_taxes'];
		$data['action'] = URL.DIR_ROUTE.'tax/action';
		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);
		
		/*Render User list view*/
		$this->view->render('setting/tax_list.tpl', $data);
	}

	public function indexAction()
	{
		$this->commons->isAdmin();
		/**
		* Check if from is submitted or not 
		**/
		if (!isset($_POST['submit'])) {
			$this->url->redirect('taxes');
			exit();
		}
		/**
		* Validate form data
		* If some data is missing or data does not match pattern
		* Return to info view 
		**/
		if ($validate_field = $this->validateField()) {
			$this->session->data['message'] = array('alert' => 'error', 'value' => 'Please enter valid '.implode(", ",$validate_field).'!');
			$this->url->redirect('taxes');
		}

		if ($this->commons->validateToken($this->url->post('_token'))) {
			$this->url->redirect('taxes');
		}

		if (!empty($this->url->post('id'))) {
			$result = $this->taxModel->updateTax($this->url->post);
			$this->session->data['message'] = array('alert' => 'success', 'value' => 'Tax Rate updated successfully.');
			$this->url->redirect('taxes');
		}
		else {
			$result = $this->taxModel->createTax($this->url->post);
			$this->session->data['message'] = array('alert' => 'success', 'value' => 'Tax Rate created successfully.');
			$this->url->redirect('taxes');
		}
	}

	public function indexDelete()
	{
		$this->commons->isAdmin();
		$result = $this->taxModel->deleteTax($this->url->post('id'));
		$this->session->data['message'] = array('alert' => 'success', 'value' => 'Tax Rate deleted successfully.');
		$this->url->redirect('taxes');
	}

	public function validateField()
	{
		$error = [];
		$error_flag = false;
		if ($this->commons->validateText($this->url->post('name'))) {
			$error_flag = true;
			$error['title'] = 'Tax Name!';
		}

		if ($this->commons->validateNumeric($this->url->post('rate'))) {
			$error_flag = true;
			$error['author'] = 'Tax Rate!';
		}
		
		if ($error_flag) {
			return $error;
		} else {
			return false;
		}
	}
}