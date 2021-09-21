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
	* Info index method
	* This method will be called on Info edit view
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
		* Get all info data from DB using info model's method
		**/
		$data['result'] = $this->infoModel->getInfo();
		/* Set all info data to array to pass to view */
		$data['address'] = json_decode($data['result']['address'], true);
		$data['invoice'] = json_decode($data['result']['invoice_setting'], true);
		
		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}
		$data['page_title'] = $data['lang']['common']['text_organisation_info'];
		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);
		/*Set action method for form submit call*/
		$data['action'] = URL.DIR_ROUTE.'info/action';
		/*Render Info view*/
		$this->view->render('setting/info.tpl', $data);
	}
	/**
	* Info index action method
	* This method will be called on Info submit/save view
	**/
	public function indexAction()
	{
		$this->commons->isAdmin();
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
			$this->session->data['message'] = array('alert' => 'error', 'value' => 'Please enter valid '.implode(", ",$validate_field).'!');
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
		$data['invoice'] = json_encode($data['invoice']);
		$result = $this->infoModel->updateInfo($data);
		
		$this->session->data['message'] = array('alert' => 'success', 'value' => 'Info updated successfully.');
		$this->url->redirect('info');
	}

	public function customization()
	{
		$this->commons->isAdmin();

		/*Get User name and role*/
		$data = $this->commons->getUser();

		/*Load Language File*/
		require DIR_BUILDER.'language/'.$data['info']['language'].'/common.php';
		$data['lang']['common'] = $lang;
		require DIR_BUILDER.'language/'.$data['info']['language'].'/info.php';
		$data['lang']['info'] = $info;

		/**
		* Get all info data from DB using info model's method
		**/
		$data['result'] = json_decode($this->infoModel->getCustomization(), true);

		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}
		$data['page_title'] = $data['lang']['common']['text_theme_customization'];
		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);
		/*Set action method for form submit call*/
		$data['action'] = URL.DIR_ROUTE.'customization/action';
		/*Render Info view*/
		$this->view->render('setting/customization.tpl', $data);
	}

	public function customizationAction()
	{
		$this->commons->isAdmin();
		/**
		* Check if from is submitted or not 
		**/
		if (!isset($_POST['submit'])) {
			$this->url->redirect('customization');
			exit();
		}

		if ($this->commons->validateToken($this->url->post('_token'))){
			$this->url->redirect('customization');
		}
		$temp = $this->url->post;
		$temp['layout_menu'] = isset($temp['layout_menu']) ? $temp['layout_menu'] : false;
		$data = array('layout' => $temp['layout'],
			'layout_fixed' => $temp['layout_fixed'],
			'layout_menu' => $temp['layout_menu'],
			'side_menu' => $temp['side-menu'], 
			'header_color' => $temp['header-color']
		);
		$result = $this->infoModel->updateCustomization(json_encode($data));
		
		$this->session->data['message'] = array('alert' => 'success', 'value' => 'Customization updated successfully.');
		$this->url->redirect('customization');
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

		if ($error_flag) {
			return $error;
		} else {
			return false;
		}
	}
}