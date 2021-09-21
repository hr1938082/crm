<?php

/**
* Info Controller
*/
class InfoController extends Controller
{
	/**
	* Private Info model variable
	* This will be used for calling Info model's function
	**/
	private $infoModel;
	function __construct()
	{
		parent::__construct();
		$this->commons = new CommonsController();
		/*Intilize info model*/
		$this->infoModel = new Info();
	}
	/**
	* Info index edit method
	* This method will be called on Info edit view
	**/
	public function index()
	{
		/*Get User name and role*/
		$data = $this->commons->getUser();
		
		/**
		* Get all info data from DB using info model's method
		**/
		$data['result'] = $this->infoModel->getInfo();
		/* Set all info data to array to pass to view */
		$data['address'] = json_decode($data['result']['address'], true);

		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}
		$data['page_title'] = 'Organisation Info';
		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);
		/*Set action method for form submit call*/
		$data['action'] = URL_CLIENTS.DIR_ROUTE.'info/action';
		/*Render Info view*/
		$this->view->render('setting/info.tpl', $data);
	}
	/**
	* Info index action method
	* This method will be called on Info submit/save view
	**/
	public function indexAction()
	{
		/**
		* Check if from is submitted or not 
		**/
		if (!isset($_POST['submit'])) {
			$this->url->redirect('info');
			exit();
		}
		/**
		* Validate form data
		* If some data is missing or data does not match pattern
		* Return to info view 
		**/
		if ($validate_field = $this->validateField()) {
			$this->session->data['message'] = array('alert' => 'danger', 'value' => 'Please enter valid '.implode(", ",$validate_field).'!');
			$this->url->redirect('info');
		}

		if ($this->commons->validateToken($this->url->post('_token'))){
			$this->url->redirect('info');
		}
		$this->update();
	}

	protected function update()
	{
		$data = $this->url->post('info');
		$data['address'] = json_encode($data['address']);
		$result = $this->infoModel->updateInfo($data);
		
		$this->session->data['message'] = array('alert' => 'success', 'value' => 'Info updated successfully.');
		$this->url->redirect('info');
	}

	protected function validateField()
	{
		$error = [];
		$error_flag = false;

		if ($this->commons->validateText($this->url->post('info')['name'])) {
			$error_flag = true;
			$error['name'] = 'Name';
		}

		if ($this->commons->validateEmail($this->url->post('info')['email'])) {
			$error_flag = true;
			$error['email'] = 'Email Address';
		}

		if ($this->commons->validateText($this->url->post('info')['phone'])) {
			$error_flag = true;
			$error['mobile'] = 'Phone number';
		}

		if ($this->commons->validateText($this->url->post('info')['currency'])) {
			$error_flag = true;
			$error['currency'] = 'Currency Code';
		}

		if ($error_flag) {
			return $error;
		} else {
			return false;
		}
	}
}