<?php

class WebClientsController extends Controller{

    private $webclient;
	function __construct()
	{
		parent::__construct();
		$this->commons = new CommonsController();
		/*Intilize User model*/
		$this->webclient = new WebClient();
	}
    public function Index()
    {
		/*Get User name and role*/
		$data = $this->commons->getUser();
		/**
		* Get all User data from DB using User model 
		**/

		$data['result'] = $this->webclient->selectWebClient();

		/*Load Language File*/
		require DIR_BUILDER.'language/'.$data['info']['language'].'/common.php';
		$data['lang']['common'] = $lang;
		/* Set page title */
		$data['page_title'] = "Websites";
		
		/*Render User list view*/
		$this->view->render('webclients/webclients.tpl', $data);
    }
	public function IndexAdd()
	{
		if (!$this->commons->hasPermission('project/add')) {
			Not_foundController::show('403');
			exit();
		}
		/*Get User name and role*/
		$data = $this->commons->getUser();
		/**
		* Get all User data from DB using User model 
		**/

		$data['result'] = NULL;

		/*Load Language File*/
		require DIR_BUILDER.'language/'.$data['info']['language'].'/common.php';
		$data['lang']['common'] = $lang;
		require DIR_BUILDER.'language/'.$data['info']['language'].'/project.php';
		$data['lang']['project'] = $project;

		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}
		/* Set page title */
		$data['page_title'] = "Add Websites";
		$data['action'] = URL.DIR_ROUTE.'webclient/action';
		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);

		/*Render User list view*/
		$this->view->render('webclients/webclients_form.tpl', $data);
	}
	public function IndexEdit()
	{
		/**
		* Check if id exist in url if not exist then redirect to Item list view 
		**/
		$id = (int)$this->url->get('id');
		if (empty($id) || !is_int($id)) {
			$this->url->redirect('contacts');
		}
		/*Get User name and role*/
		$data = $this->commons->getUser();
		/**
		* Get all User data from DB using User model 
		**/
		
		if (!$user = $this->commons->checkUser()) {
			$data['admin'] = true;
			$data['result'] = $this->webclient->selectWebClient($id);
		}
		/*Load Language File*/
		require DIR_BUILDER.'language/'.$data['info']['language'].'/common.php';
		$data['lang']['common'] = $lang;
		require DIR_BUILDER.'language/'.$data['info']['language'].'/project.php';
		$data['lang']['project'] = $project;

		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}
		/* Set page title */
		$data['page_title'] = "Edit Websites";
		$data['action'] = URL.DIR_ROUTE.'webclient/action';
		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);

		/*Render User list view*/
		$this->view->render('webclients/webclients_form.tpl', $data);
	}

	public function IndexAction()
	{
		/**
		* Check if from is submitted or not 
		**/
		
		if (!isset($_POST['submit'])) {
			$this->url->redirect('webclients');
			exit();
		}
		
		if (!empty($this->url->post('id'))) {
			$data = $this->url->post('website');
			$data['id'] = $this->url->post('id');
			if ($data['site_name'] == null) {
				$this->url->redirect('webclients/form&id='.$this->url->post('id').'&error=invalid website name');
			}
			$result = $this->webclient->updateWebClient($data);
			$this->url->redirect('webclients/form&id='.$this->url->post('id'));
		}
		else {
			$data = $this->url->post('website');
			if ($data['site_name'] == null) {
				$this->url->redirect('webclients/form&id='.$this->url->post('id').'&error=invalid website name');
			}
			$result = $this->webclient->createWebClient($data);
			$this->url->redirect('webclients');
		}
	}

	public function IndexDelete()
	{
		$this->webclient->deleteWebClient($this->url->post('id'));
		$this->url->redirect('webclients');
	}
}

?>