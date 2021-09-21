<?php

/**
* TemplateController
*/
class TemplateController extends Controller
{
	private $templateModel;
	function __construct()
	{
		parent::__construct();
		$this->commons = new CommonsController();
		/*Intilize User model*/
		$this->templateModel = new Template();
	}

	public function index()
	{
		$this->commons->isAdmin();

		/*Get User name and role*/
		$data = $this->commons->getUser();
		
		/*Load Language File*/
		require DIR_BUILDER.'language/'.$data['info']['language'].'/common.php';
		$data['lang']['common'] = $lang;
		
		$data['template'] = $this->url->get('for');

		if (empty($data['template'])) {
			Not_foundController::show('403');
			exit();
		}

		$data['result'] = $this->templateModel->getTemplate($data['template']);
		$data['template_menu'] = $this->templateModel->getTemplateMenu();

		if (empty($data['result'])) {
			Not_foundController::show('404');
			exit();
		}

		/**
		* Get all Event data from DB using Event model
		* According to user_role 
		**/

		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}

		/* Set Page title and action */
		$data['action'] = URL.DIR_ROUTE.'emailtemplate/action';
		
		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);


		/*Render Calendar list view*/
		$this->view->render('template/template_form.tpl', $data);
	}

	public function indexAction()
	{
		$this->commons->isAdmin();
		/**
		* Check if from is submitted or not 
		**/
		if (!isset($_POST['submit'])) {
			Not_foundController::show('404');
			exit();
		}
		/**
		* Validate form data
		* If some data is missing or data does not match pattern
		* Return to info view 
		**/
		$data = $this->url->post('mail');
		
		if ($validate_field = $this->validateField($data)) {
			$this->session->data['message'] = array('alert' => 'error', 'value' => 'Please enter valid '.implode(", ",$validate_field).'!');
			$this->url->redirect('emailtemplate&for='.$data['template']);
		}

		if ($this->commons->validateToken($this->url->post('_token'))){
			$this->url->redirect('emailtemplate&for='.$data['template']);
		}

		$result = $this->templateModel->updateTemplate($data);

		$this->session->data['message'] = array('alert' => 'success', 'value' => 'Template updated successfully.');
		$this->url->redirect('emailtemplate&for='.$data['template']);
	}

	protected function validateField($data)
	{
		$error = [];
		$error_flag = false;

		if ($this->commons->validateText($data['subject'])) {
			$error_flag = true;
			$error['subject'] = 'Subject';
		}

		if ($this->commons->validateText($data['template'])) {
			$error_flag = true;
			$error['template'] = 'Template';
		}

		if ($this->commons->validateText($data['message'])) {
			$error_flag = true;
			$error['message'] = 'message';
		}

		if ($error_flag) {
			return $error;
		} else {
			return false;
		}
	}
}