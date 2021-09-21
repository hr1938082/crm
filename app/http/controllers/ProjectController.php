<?php

/**
 * ProjectController
 */
class ProjectController extends Controller
{
	private $projectModel;
	private $orderModel;
	private $gatewayModel;
	private $website;
	function __construct()
	{
		parent::__construct();
		$this->commons = new CommonsController();
		/*Intilize User model*/
		$this->projectModel = new Project();
		$this->orderModel = new Order();
		$this->gatewayModel = new Gateway();
		$this->website = new WebClient();
	}
	/**
	 * Project index method
	 * This method will be called on Project list view
	 **/
	public function index()
	{
		if (!$this->commons->hasPermission('projects')) {
			Not_foundController::show('403');
			exit();
		}
		/*Get User name and role*/
		$data = $this->commons->getUser();
		/**
		 * Get all User data from DB using User model 
		 **/

		if ($user = $this->commons->checkUser()) {
			$data['result'] = $this->projectModel->getProjects($user);
		} else {
			$data['staff'] = $this->projectModel->getStaff();
			// var_dump($data['staff']);
			// die;
			$data['result'] = $this->projectModel->getProjects();
			$data['payments'] = $this->gatewayModel->selectGateway();
			$data['websites'] = $this->website->selectWebClient();
		}
		/*Load Language File*/
		require DIR_BUILDER . 'language/' . $data['info']['language'] . '/common.php';
		$data['lang']['common'] = $lang;
		require DIR_BUILDER . 'language/' . $data['info']['language'] . '/project.php';
		$data['lang']['project'] = $project;

		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}
		/* Set page title */
		$data['page_title'] = $data['lang']['common']['text_projects'];

		/*Render User list view*/
		$this->view->render('project/project_list.tpl', $data);
	}
	/**
	 * Project index ADD method
	 * This method will be called on Project Add view
	 **/
	public function indexAdd()
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
		$data['currency'] = $this->projectModel->getCurrency();
		$data['customers'] = $this->projectModel->getCustomers();
		$data['staff'] = $this->projectModel->getStaff();
		$data['websites'] = $this->website->selectWebClient();

		/*Load Language File*/
		require DIR_BUILDER . 'language/' . $data['info']['language'] . '/common.php';
		$data['lang']['common'] = $lang;
		require DIR_BUILDER . 'language/' . $data['info']['language'] . '/project.php';
		$data['lang']['project'] = $project;

		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}
		/* Set page title */
		$data['page_title'] = $data['lang']['project']['text_new_project'];
		$data['action'] = URL . DIR_ROUTE . 'project/action';
		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);

		/*Render User list view*/
		$this->view->render('project/project_form.tpl', $data);
	}
	/**
	 * Project index Edit method
	 * This method will be called on Project Edit view
	 **/
	public function indexEdit()
	{
		if (!$this->commons->hasPermission('project/edit')) {
			Not_foundController::show('403');
			exit();
		}
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
		if ($user = $this->commons->checkUser()) {
			$data['user']['user_id'] = $this->session->data['user_id'];
			$data['admin'] = false;
			$data['result'] = $this->projectModel->getProject($id, $user);
			$data['customers'] = $this->projectModel->getCustomers($user);
		} else {
			$data['admin'] = true;
			$data['result'] = $this->projectModel->getProject($id);
			$data['customers'] = $this->projectModel->getCustomers();
			$data['websites'] = $this->website->selectWebClient();
		}

		if (empty($data['result'])) {
			$this->url->redirect('projects');
		}
		$data['order'] = $this->orderModel->getOrder($data['result']["order_id"]);
		$data['gateway'] = $this->gatewayModel->selectGateway($id);
		$data['currency'] = $this->projectModel->getCurrency();
		$data['staff'] = $this->projectModel->getStaff();
		$data['comments'] = $this->projectModel->getComments($id);
		$data['documents'] = $this->projectModel->getDocuments($id);
		$data['result']['staff'] = json_decode($data['result']['staff'], true);
		$data['result']['task'] = json_decode($data['result']['task'], true);

		/*Load Language File*/
		require DIR_BUILDER . 'language/' . $data['info']['language'] . '/common.php';
		$data['lang']['common'] = $lang;
		require DIR_BUILDER . 'language/' . $data['info']['language'] . '/project.php';
		$data['lang']['project'] = $project;

		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}

		/* Set page title */
		$data['page_title'] = $data['lang']['common']['text_edit'] . ' ' . $data['lang']['common']['text_project'];
		$data['action'] = URL . DIR_ROUTE . 'project/action';
		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);

		/*Render User list view*/
		$this->view->render('project/project_form.tpl', $data);
	}
	/**
	 * Project index Action method
	 * This method will be called on Project Submit or update
	 **/
	public function indexAction()
	{

		/**
		 * Check if from is submitted or not 
		 **/
		if (!isset($_POST['submit'])) {
			$this->url->redirect('projects');
			exit();
		}
		/**
		 * Validate form data
		 * If some data is missing or data does not match pattern
		 * Return to info view 
		 **/
		if ($validate_field = $this->validateField()) {
			$this->session->data['message'] = array('alert' => 'error', 'value' => 'Please enter valid ' . implode(", ", $validate_field) . '!');
			$this->url->redirect('projects');
		}

		if ($this->commons->validateToken($this->url->post('_token'))) {
			$this->url->redirect('projects');
		}

		if (!empty($this->url->post('id'))) {
			$data = $this->url->post('project');
			$data['staff'] = json_encode($data['staff']);
			$data['task'] = json_encode($data['task']);
			$data['id'] = $this->url->post('id');
			$data['website_id'] = $this->url->post('project')['website_id'];
			$data['start_date'] = date_format(date_create($data['start_date']), 'Y-m-d');
			$data['due_date'] = date_format(date_create($data['due_date']), 'Y-m-d');
			$result = $this->projectModel->updateProject($data);
			$result1 = $this->orderModel->update($data["order"]);
			$this->session->data['message'] = array('alert' => 'success', 'value' => 'Project updated successfully.');
			$this->url->redirect('project/edit&id=' . $this->url->post('id'));
		} else {
			$data = $this->url->post('project');
			$data['staff'] = json_encode($data['staff']);
			$data['task'] = json_encode($data['task']);
			$data['website_id'] = $this->url->post('project')['website_id'];
			$data['start_date'] = date_format(date_create($data['start_date']), 'Y-m-d');
			$data['due_date'] = date_format(date_create($data['due_date']), 'Y-m-d');
			$result1 = $this->orderModel->Create($data["order"]);
			$data["order_id"] = (string)$result1;
			$result = $this->projectModel->createProject($data);
			$this->session->data['message'] = array('alert' => 'success', 'value' => 'Project created successfully.');
			$this->url->redirect('project/edit&id=' . $result);
		}
	}

	public function AssignStaff()
	{
		$staff['name'] = $this->url->post('staff');
		$staff['hours'] = "";
		$staff['rate'] = "";
		$staff = json_encode([$staff]);
		$id = $this->url->post('delete');
		if ($id) {
			foreach ($id as $value) {
				$this->projectModel->updateStaff(["id" => $value, 'staff' => $staff]);
			}
		}
		$data = $this->commons->getUser();
		/**
		 * Get all User data from DB using User model 
		 **/

		if ($user = $this->commons->checkUser()) {
			$data['result'] = $this->projectModel->getProjects($user);
		} else {
			$data['staff'] = $this->projectModel->getStaff();
			// var_dump($data['staff']);
			// die;
			$data['result'] = $this->projectModel->getProjects();
			$data['payments'] = $this->gatewayModel->selectGateway();
			$data['websites'] = $this->website->selectWebClient();
		}
		/*Load Language File*/
		require DIR_BUILDER . 'language/' . $data['info']['language'] . '/common.php';
		$data['lang']['common'] = $lang;
		require DIR_BUILDER . 'language/' . $data['info']['language'] . '/project.php';
		$data['lang']['project'] = $project;

		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}
		/* Set page title */
		$data['page_title'] = $data['lang']['common']['text_projects'];

		/*Render User list view*/
		$this->view->render('project/project_list.tpl', $data);
	}
	/**
	 * Project make Comment Method
	 * This method will be called to add comment on project
	 **/
	public function makeComment()
	{
		if ($this->commons->validateText($this->url->post('comment'))) {
			echo 1;
		}

		$data = $this->url->post;
		$data['comment_by'] = $this->session->data['user_id'];

		$result = $this->projectModel->createComment($data);
		print_r($result);
	}
	/**
	 * Project index Delete method
	 * This method will be called on Project Delete view
	 **/
	public function indexDelete()
	{
		// echo "<pre>";
		// var_dump($this->url->post);
		// echo "</pre>";
		// die;
		if (!$this->commons->hasPermission('project/delete')) {
			Not_foundController::show('403');
			exit();
		}
		$delete = $this->url->post('delete');
		if ($delete) {
			foreach ($delete as $id) {
				$gateway = $this->gatewayModel->deleteGateway($id);
				$result = $this->projectModel->deleteProject($id);
				$result1 = $this->orderModel->delete($result);
			}
		} else {
			$gateway = $this->gatewayModel->deleteGateway($this->url->post('id'));
			$result = $this->projectModel->deleteProject($this->url->post('id'));
			$result1 = $this->orderModel->delete($result);
		}

		$this->session->data['message'] = array('alert' => 'success', 'value' => 'Project deleted successfully.');
		$this->url->redirect('projects');
	}
	/**
	 * Validate input field
	 * @return [boolean] [true][false]
	 */
	public function validateField()
	{
		$error = [];
		$error_flag = false;

		if ($this->commons->validateText($this->url->post('project')['name'])) {
			$error_flag = true;
			$error['author'] = 'Project name!';
		}

		if ($error_flag) {
			return $error;
		} else {
			return false;
		}
	}
}
