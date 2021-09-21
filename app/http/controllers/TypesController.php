<?php

/**
* TypeController
*/
class TypesController extends Controller
{
	private $typeModel;
	function __construct()
	{
		parent::__construct();
		$this->commons = new CommonsController();
		/*Intilize User model*/
		$this->typeModel = new Types();
	}

	public function departments()
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
		$data['result'] = $this->typeModel->getDepartments();
		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}
		/* Set page title */
		$data['page_title'] = $data['lang']['common']['text_departments'];
		$data['action'] = URL.DIR_ROUTE.'department/action';
		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);
		
		/*Render User list view*/
		$this->view->render('setting/department.tpl', $data);
	}

	public function departmentAction()
	{
		$this->commons->isAdmin();
		/**
		* Check if from is submitted or not 
		**/
		if (!isset($_POST['submit'])) {
			$this->url->redirect('departments');
			exit();
		}
		/**
		* Validate form data
		* If some data is missing or data does not match pattern
		* Return to info view 
		**/
		if ($validate_field = $this->validateField()) {
			$this->session->data['message'] = array('alert' => 'error', 'value' => 'Please enter valid '.implode(", ",$validate_field).'!');
			$this->url->redirect('departments');
		}
		if ($this->commons->validateToken($this->url->post('_token'))) {
			$this->url->redirect('departments');
		}

		if (!empty($this->url->post('id'))) {
			$result = $this->typeModel->updateDepartment($this->url->post);
			$this->session->data['message'] = array('alert' => 'success', 'value' => 'Department updated successfully.');
			$this->url->redirect('departments');
		}
		else {
			$result = $this->typeModel->createDepartment($this->url->post);
			$this->session->data['message'] = array('alert' => 'success', 'value' => 'Department created successfully.');
			$this->url->redirect('departments');
		}
	}

	public function departmentDelete()
	{
		$this->commons->isAdmin();
		$result = $this->typeModel->deleteDepartment($this->url->post('id'));
		$this->session->data['message'] = array('alert' => 'success', 'value' => 'Department deleted successfully.');
		$this->url->redirect('departments');
	}

	public function paymentType()
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
		$data['result'] = $this->typeModel->getPaymentTypes();
		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}
		/* Set page title */
		$data['page_title'] = $data['lang']['settings']['text_payment_method'];
		$data['action'] = URL.DIR_ROUTE.'paymenttype/action';
		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);
		
		/*Render User list view*/
		$this->view->render('setting/payment_type.tpl', $data);
	}

	public function paymentTypeAction()
	{
		$this->commons->isAdmin();
		/**
		* Check if from is submitted or not 
		**/
		if (!isset($_POST['submit'])) {
			$this->url->redirect('paymenttype');
			exit();
		}
		/**
		* Validate form data
		* If some data is missing or data does not match pattern
		* Return to info view 
		**/
		if ($validate_field = $this->validateField()) {
			$this->session->data['message'] = array('alert' => 'error', 'value' => 'Please enter valid '.implode(", ",$validate_field).'!');
			$this->url->redirect('paymenttype');
		}
		if ($this->commons->validateToken($this->url->post('_token'))) {
			$this->url->redirect('paymenttype');
		}

		if (!empty($this->url->post('id'))) {
			$result = $this->typeModel->updatePaymentType($this->url->post);
			$this->session->data['message'] = array('alert' => 'success', 'value' => 'Payment Method updated successfully.');
			$this->url->redirect('paymenttype');
		}
		else {
			$result = $this->typeModel->createPaymentType($this->url->post);
			$this->session->data['message'] = array('alert' => 'success', 'value' => 'Payment Method created successfully.');
			$this->url->redirect('paymenttype');
		}
	}

	public function paymentTypeDelete()
	{
		$this->commons->isAdmin();
		$result = $this->typeModel->deletePaymentType($this->url->post('id'));
		$this->session->data['message'] = array('alert' => 'success', 'value' => 'Payment Method deleted successfully.');
		$this->url->redirect('paymenttype');
	}

	public function paymentStatus()
	{
		$this->commons->isAdmin();
		/*Get User name and role*/
		$data['user'] = $this->commons->getUser();
		/**
		* Get all Tax data from DB using Tax model 
		**/
		$data['result'] = $this->typeModel->getPaymentStatus();
		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}
		/* Set page title */
		$data['page_title'] = 'Payment Status';
		$data['action'] = URL.DIR_ROUTE.'paymentstatus/action';
		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);
		
		/*Render User list view*/
		$this->view->render('setting/payment_status.tpl', $data);
	}

	public function paymentStatusAction()
	{
		$this->commons->isAdmin();
		/**
		* Check if from is submitted or not 
		**/
		if (!isset($_POST['submit'])) {
			$this->url->redirect('paymentstatus');
			exit();
		}
		/**
		* Validate form data
		* If some data is missing or data does not match pattern
		* Return to info view 
		**/
		if ($validate_field = $this->validateField()) {
			$this->session->data['message'] = array('alert' => 'error', 'value' => 'Please enter valid '.implode(", ",$validate_field).'!');
			$this->url->redirect('paymentstatus');
		}
		if ($this->commons->validateToken($this->url->post('_token'))) {
			$this->url->redirect('paymentstatus');
		}

		if (!empty($this->url->post('id'))) {
			$result = $this->typeModel->updatePaymentStatus($this->url->post);
			$this->session->data['message'] = array('alert' => 'success', 'value' => 'Payment Status updated successfully.');
			$this->url->redirect('paymentstatus');
		}
		else {
			$result = $this->typeModel->createPaymentStatus($this->url->post);
			$this->session->data['message'] = array('alert' => 'success', 'value' => 'Payment Status created successfully.');
			$this->url->redirect('paymentstatus');
		}
	}

	public function paymentStatusDelete()
	{
		$this->commons->isAdmin();
		$result = $this->typeModel->deletePaymentStatus($this->url->post('id'));
		$this->session->data['message'] = array('alert' => 'success', 'value' => 'Payment Status deleted successfully.');
		$this->url->redirect('paymentstatus');
	}

	public function currency()
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
		$data['result'] = $this->typeModel->getCurrency();
		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}
		/* Set page title */
		$data['page_title'] = $data['lang']['settings']['text_currencies'];
		$data['action'] = URL.DIR_ROUTE.'currency/action';
		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);

		/*Render User list view*/
		$this->view->render('setting/currency.tpl', $data);
	}

	public function currencyAction()
	{
		$this->commons->isAdmin();
		/**
		* Check if from is submitted or not 
		**/
		if (!isset($_POST['submit'])) {
			$this->url->redirect('currency');
			exit();
		}
		/**
		* Validate form data
		* If some data is missing or data does not match pattern
		* Return to info view 
		**/
		if ($validate_field = $this->validateField()) {
			$this->session->data['message'] = array('alert' => 'error', 'value' => 'Please enter valid '.implode(", ",$validate_field).'!');
			$this->url->redirect('currency');
		}
		if ($this->commons->validateToken($this->url->post('_token'))) {
			$this->url->redirect('currency');
		}

		if (!empty($this->url->post('id'))) {
			$result = $this->typeModel->updateCurrency($this->url->post);
			$this->session->data['message'] = array('alert' => 'success', 'value' => 'Currency updated successfully.');
			$this->url->redirect('currency');
		}
		else {
			$result = $this->typeModel->createCurrency($this->url->post);
			$this->session->data['message'] = array('alert' => 'success', 'value' => 'Currency created successfully.');
			$this->url->redirect('currency');
		}
	}

	public function currencyDelete()
	{
		$this->commons->isAdmin();
		$result = $this->typeModel->deleteCurrency($this->url->post('id'));
		$this->session->data['message'] = array('alert' => 'success', 'value' => 'Currency deleted successfully.');
		$this->url->redirect('currency');
	}

	public function expenseType()
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
		$data['result'] = $this->typeModel->getExpenseTypes();
		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}
		/* Set page title */
		$data['page_title'] = $data['lang']['common']['text_expense_types'];
		$data['action'] = URL.DIR_ROUTE.'expensetype/action';
		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);
		
		/*Render User list view*/
		$this->view->render('setting/expense_type.tpl', $data);
	}

	public function expenseTypeAction()
	{
		$this->commons->isAdmin();
		/**
		* Check if from is submitted or not 
		**/
		if (!isset($_POST['submit'])) {
			$this->url->redirect('expensetype');
			exit();
		}
		/**
		* Validate form data
		* If some data is missing or data does not match pattern
		* Return to info view 
		**/
		if ($validate_field = $this->validateField()) {
			$this->session->data['message'] = array('alert' => 'error', 'value' => 'Please enter valid '.implode(", ",$validate_field).'!');
			$this->url->redirect('expensetype');
		}
		if ($this->commons->validateToken($this->url->post('_token'))) {
			$this->url->redirect('expensetype');
		}

		if (!empty($this->url->post('id'))) {
			$result = $this->typeModel->updateExpenseType($this->url->post);
			$this->session->data['message'] = array('alert' => 'success', 'value' => 'Expense Type updated successfully.');
			$this->url->redirect('expensetype');
		}
		else {
			$result = $this->typeModel->createExpenseType($this->url->post);
			$this->session->data['message'] = array('alert' => 'success', 'value' => 'Expense Type created successfully.');
			$this->url->redirect('expensetype');
		}
	}

	public function expenseTypeDelete()
	{
		$this->commons->isAdmin();
		$result = $this->typeModel->deleteExpenseType($this->url->post('id'));
		$this->session->data['message'] = array('alert' => 'success', 'value' => 'Expense Type deleted successfully.');
		$this->url->redirect('expensetype');
	}

	public function paymentGateway()
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
		
		$data['result'] = $this->typeModel->getPaymentGateway();
		
		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}
		/* Set page title */
		$data['page_title'] = $data['lang']['settings']['text_payment_gateway'];
		$data['action'] = URL.DIR_ROUTE.'paymentgateway/action';
		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);

		/*Render User list view*/
		$this->view->render('setting/payment_gateway.tpl', $data);
	}

	public function paymentGatewayAction()
	{
		$this->commons->isAdmin();
		/**
		* Check if from is submitted or not 
		**/
		if (!isset($_POST['submit'])) {
			$this->url->redirect('paymentgateway');
			exit();
		}
		/**
		* Validate form data
		* If some data is missing or data does not match pattern
		* Return to info view 
		**/

		if ($this->commons->validateToken($this->url->post('_token'))) {
			$this->url->redirect('paymentgateway');
		}
		
		$result = $this->typeModel->updatePaymentGateway($this->url->post('gateway'));
		$this->session->data['message'] = array('alert' => 'success', 'value' => 'Payment Gateway updated successfully.');
		$this->url->redirect('paymentgateway');
	}

	public function validateField()
	{
		$error = [];
		$error_flag = false;
		if ($this->commons->validateText($this->url->post('name'))) {
			$error_flag = true;
			$error['title'] = 'Name!';
		}
		
		if ($error_flag) {
			return $error;
		} else {
			return false;
		}
	}
}