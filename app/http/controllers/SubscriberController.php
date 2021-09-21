<?php

/**
* Subscriber Controller
*/
class SubscriberController extends Controller
{
	/**
	* Subscriber Blog model variable
	* This will be used for calling Subscriber model's function
	**/
	private $subscriberModel;
	public $url;
	function __construct()
	{
		parent::__construct();
		$this->commons = new CommonsController();
		/*Intilize Subscriber model*/
		$this->subscriberModel = new Subscriber();
		$this->url = new Url();
	}
	/**
	* Subscriber index edit method
	* This method will be called on Subscriber edit view
	**/
	public function index()
	{
		if (!$this->commons->hasPermission('subscriber')) {
			Not_foundController::show('403');
			exit();
		}
		/*Get User name and role*/
		$data = $this->commons->getUser();

		/*Load Language File*/
		require DIR_BUILDER.'language/'.$data['info']['language'].'/common.php';
		$data['lang']['common'] = $lang;
		require DIR_BUILDER.'language/'.$data['info']['language'].'/users.php';
		$data['lang']['users'] = $users;

		/**
		* Get all Subscribers data from DB using Subscriber model 
		**/
		$data['result'] = $this->subscriberModel->allSubscribers();
		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}
		$data['page_title'] = $data['lang']['common']['text_subscribers'];
		/*call Subscriber list view*/
		$this->view->render('subscriber/subscriber_list.tpl', $data);
	}
	/**
	* Subscriber index add method
	* This method will be called on Subscriber add
	**/
	public function indexAdd()
	{
		if (!$this->commons->hasPermission('subscriber/add')) {
			Not_foundController::show('403');
			exit();
		}
		/*Get User name and role*/
		$data = $this->commons->getUser();

		/*Load Language File*/
		require DIR_BUILDER.'language/'.$data['info']['language'].'/common.php';
		$data['lang']['common'] = $lang;
		require DIR_BUILDER.'language/'.$data['info']['language'].'/users.php';
		$data['lang']['users'] = $users;

		/* Set page title */
		$data['page_title'] = $data['lang']['users']['text_new_subscriber'];
		/* Set empty data to array */
		$data['result'] =  NULL;
		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}
		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);
		$data['action'] = URL.DIR_ROUTE.'subscriber/action';
		/*Render Blog add view*/
		$this->view->render('subscriber/subscribe_form.tpl', $data);
	}
	/**
	* Subscriber index edit method
	* This method will be called on Subscriber edit view
	**/
	public function indexEdit()
	{
		if (!$this->commons->hasPermission('subscriber/edit')) {
			Not_foundController::show('403');
			exit();
		}
		/**
		* Check if id exist in url if not exist then redirect to Subscriber list view 
		**/
		$id = (int)$this->url->get('id');
		if ( empty($id) || !is_int($id) ) {
			$this->url->redirect('subscriber');
		}
		/**
		* Call getSubscriber method from Subscriber model to get data from DB for single Subscriber
		* If Subscriber does not exist then redirect it to Subscriber list view
		**/
		$subscriber = $this->subscriberModel->getSubscriber($id);
		if (!$subscriber) {
			$this->session->data['message'] = array('alert' => 'warning', 'value' => 'Subscriber does not exist in database!');
			$this->url->redirect('subscriber');
		}
		/*Get User name and role*/
		$data = $this->commons->getUser();

		/*Load Language File*/
		require DIR_BUILDER.'language/'.$data['info']['language'].'/common.php';
		$data['lang']['common'] = $lang;
		require DIR_BUILDER.'language/'.$data['info']['language'].'/users.php';
		$data['lang']['users'] = $users;

		/* Set Edit Subscriber page title */
		$data['page_title'] = $data['lang']['users']['text_edit_subscriber'];
		$data['result'] = $subscriber;
		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}
		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);
		$data['action'] = URL.DIR_ROUTE.'subscriber/action';
		/*Render Subscriber edit view*/
		$this->view->render('subscriber/subscribe_form.tpl', $data);
	}
	/**
	* Info index action method
	* This method will be called on subscriber submit/save
	**/
	public function indexAction()
	{
		/**
		* Check if from is submitted or not 
		**/
		if (!isset($_POST['submit'])) {
			$this->url->redirect('subscriber');
			exit();
		}
		/**
		* Validate form data
		* If some data is missing or data does not match pattern
		* Return to info view 
		**/
		if ($validate_field = $this->validateField()) {
			$this->session->data['message'] = array('alert' => 'error', 'value' => 'Please enter/select valid '.implode(", ",$validate_field).'!');
			if (!empty($this->url->post('id'))) {
				$this->url->redirect('subscriber/edit&id='.$this->url->post('id'));
			} else {
				$this->url->redirect('subscriber/add');
			}
		}

		if ($this->commons->validateToken($this->url->post('_token'))){
			if (!empty($this->url->post('id'))) {
				$this->url->redirect('subscriber/edit&id='.$this->url->post('id'));
			} else {
				$this->url->redirect('subscriber/add');
			}
		}

		if (!empty($this->url->post('id'))) {
			$this->update();
		} else {
			$this->create();
		}
	}
	/**
	* Blog index delete method
	* This method will be called on blog delete action
	**/
	public function indexDelete()
	{
		/**
		* Check if from is submitted or not 
		**/
		if (!isset($_POST['delete']) || empty($this->url->post('id')) ) {
			$this->url->redirect('subscriber');
			exit();
		}
		/**
		* Call delete method
		**/
		$this->delete();
	}

	protected function update()
	{
		$data['id'] = $this->url->post('id');
		$data['email'] = $this->url->post('email');
		$data['status'] = $this->url->post('status');
		$this->subscriberModel->updateSubscriber($data);
		$this->session->data['message'] = array('alert' => 'success', 'value' => 'Subscriber updated successfully.');
		$this->url->redirect('subscriber/edit&id='.$data['id']);
	}

	protected function create()
	{
		$data['email'] = $this->url->post('email');
		if ($result = $this->subscriberModel->createSubscriber($data)) {
			$this->session->data['message'] = array('alert' => 'success', 'value' => 'Subscriber created successfully.');
			$this->url->redirect('subscriber/edit&id='.$result);
		} else {
			$this->session->data['message'] = array('alert' => 'error', 'value' => 'Subscriber does not created (Server Error).');
			$this->url->redirect('subscriber/add');
		}
	}

	protected function delete()
	{
		if (!$this->commons->hasPermission('subscriber/delete')) {
			Not_foundController::show('403');
			exit();
		}
		$result = $this->subscriberModel->deleteSubscriber($this->url->post('id'));
		$this->session->data['message'] = array('alert' => 'success', 'value' => 'Subscriber deleted successfully.');
		$this->url->redirect('subscriber');
	}

	protected function validateField()
	{
		$error = [];
		$error_flag = false;
		if ($email = $this->commons->validateEmail($this->url->post('email'))) {
			$error_flag = true;
			$error['email'] = 'Email Address';
		}

		if ($error_flag) {
			return $error;
		} else {
			return false;
		}
	}
}