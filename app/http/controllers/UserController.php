<?php

/**
* User Controller
*/
class UserController extends Controller
{
	/**
	* Private User model variable
	* This will be used for calling User model's function
	**/
	private $userModel;
	function __construct()
	{
		parent::__construct();
		$this->commons = new CommonsController();
		/*Intilize User model*/
		$this->userModel = new User();
	}
	/**
	* User index method
	* This method will be called on User list view
	**/
	public function index()
	{
		if (!$this->commons->hasPermission('users')) {
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
		* Get all User data from DB using User model 
		**/
		$data['result'] = $this->userModel->allUsers();
		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}
		/* Set page title */
		$data['page_title'] = $data['lang']['common']['text_users'];
		$data['role'] = $this->session->data['role'];
		/*Render User list view*/
		$this->view->render('user/user_list.tpl', $data);
	}
	/**
	* User index add method
	* This method will be called on User add
	**/
	public function indexAdd()
	{
		if (!$this->commons->hasPermission('user/add')) {
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
		$data['page_title'] = $data['lang']['users']['text_edit_user'];
		/* Set empty data to array */
		$data['result'] =  NULL;
		$data['meta'] =  NULL;
		$data['role'] =  $this->userModel->userRole();
		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}
		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);
		$data['action'] = URL.DIR_ROUTE.'user/action';
		
		/*Render User add view*/
		$this->view->render('user/user_form.tpl', $data);
	}

	/**
	* User index edit method
	* This method will be called on User edit view
	**/
	public function indexEdit()
	{
		if (!$this->commons->hasPermission('user/edit')) {
			Not_foundController::show('403');
			exit();
		}
		/**
		* Check if id exist in url if not exist then redirect to User list view 
		**/
		$id = (int)$this->url->get('id');
		if (empty($id) || !is_int($id)) {
			$this->url->redirect('user');
		}
		/**
		* Call getUser method from Blog model to get data from DB for single User
		* If User does not exist then redirect it to User list view
		**/
		$user = $this->userModel->getUser($id);
		if (!$user) {
			$this->session->data['message'] = array('alert' => 'warning', 'value' => 'User does not exist in database!');
			$this->url->redirect('user');
		}
		$role = $this->session->data['role'];
		if ($role != "1" && $user['user_role'] == "1") {
			$this->session->data['message'] = array('alert' => 'warning', 'value' => 'Access Denied.');
			$this->url->redirect('user');
		}

		/*Get User name and role*/
		$data = $this->commons->getUser();

		/*Load Language File*/
		require DIR_BUILDER.'language/'.$data['info']['language'].'/common.php';
		$data['lang']['common'] = $lang;
		require DIR_BUILDER.'language/'.$data['info']['language'].'/users.php';
		$data['lang']['users'] = $users;
		
		$data['result'] = $user;
		$data['meta'] = json_decode($user['meta'], true);
		$data['role'] =  $this->userModel->userRole();

		$data['page_title'] = $data['lang']['users']['text_edit_user'];

		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}
		
		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);
		$data['action'] = URL.DIR_ROUTE.'user/action';
		
		/*Render User edit view*/
		$this->view->render('user/user_form.tpl', $data);
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
			$this->url->redirect('user');
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
				$this->url->redirect('user/edit&id='.$this->url->post('id'));
			}
			else {
				$this->url->redirect('user/add');
			}
		}
		
		if ($this->commons->validateToken($this->url->post('_token'))){
			if (!empty($this->url->post('id'))) {
				$this->url->redirect('user/edit&id='.$this->url->post('id'));
			} else {
				$this->url->redirect('user/add');
			}
		}

		if (!empty($this->url->post('id'))) {
			$this->update();
		} else {
			$this->create();
		}
	}
	/**
	* User index delete method
	* This method will be called on blog delete action
	**/
	public function indexDelete()
	{
		if (!$this->commons->hasPermission('user/delete')) {
			Not_foundController::show('403');
			exit();
		}
		/**
		* Check if from is submitted or not 
		**/
		if (!isset($_POST['delete']) || empty($this->url->post('id'))) {
			$this->url->redirect('user');
			exit();
		}
		/**
		* Call delete method
		**/
		$this->delete();
	}

	protected function update()
	{
		$data = $this->url->post('user');
		$data['id'] = $this->url->post('id');
		$data['meta'] = json_encode($data['meta']);
		
		$check_user = $this->userModel->checkUserName($data);
		
		/**
		* Check if @user_name already exist or not in database
		**/
		if ($check_user >= 1) {
			$this->session->data['message'] = array('alert' => "error", 'value' => "User Name ".$data['username']." already exist in database.");
			$this->url->redirect('user/edit&id='.$data['id']);
		}

		$result = $this->userModel->updateUser($data);
		
		$this->session->data['message'] = array('alert' => 'success', 'value' => 'Account updated successfully.');
		$this->url->redirect('user/edit&id='.$data['id']);
	}

	protected function create()
	{

		/**
		* Set all data to one array to pass it to model
		**/		
		
		$data = $this->url->post('user');
		
		$data['meta'] = json_encode($data['meta']);
		$check_user = $this->userModel->checkUserName($data);
		
		/**
		* Check if @user_name already exist or not in database
		**/
		if ($check_user >= 1) {
			$this->session->data['message'] = array('alert' => "error", 'value' => "User Name ".$data['username']." already exist in database.");
			$this->url->redirect('user/add');
		}

		/**
		* Check if @email already exist or not in database
		**/
		if ($this->userModel->checkUserEmail($data['email']) >= 1) {
			$this->session->data['message'] = array('alert' => 'error', 'value' => 'Email '.$data['email'].' already exist in database.');
			$this->url->redirect('user/add');
		}
		
		/**
		* Call user model to create user
		* If user created than send email and set success message 
		* If not than set error 
		**/

		$data['hash'] = md5(uniqid(mt_rand(), true));
		$data['chars'] = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789@#";
		$data['password_text'] = substr( str_shuffle( $data['chars'] ), 0, 12 );
		$data['password'] = password_hash($data['password_text'], PASSWORD_DEFAULT);
		
		$result = $this->userModel->createUser($data);
		if ($result) {
			$this->indexMail($data);
			$this->session->data['message'] = array('alert' => 'success', 'value' => 'Account created successfully.');
			$this->url->redirect('user/edit&id='.$result);
		} else {
			$this->session->data['message'] = array('alert' => 'error', 'value' => 'Account does not created (Server Error).');
			$this->url->redirect('user/add');
		}
	}

	private function indexMail($data)
	{
		$commonsModel = new Commons();
		$info = $commonsModel->getOrganization();
		$template = $this->userModel->getTemplate('newuser');
		$site_link = '<a href="'.URL.'">Click Here</a>';
		
		$message = $template['message'];
		$message = str_replace('{name}', $data['firstname'].' '.$data['lastname'], $message);
		$message = str_replace('{email}', $data['email'], $message);
		$message = str_replace('{username}', $data['username'], $message);
		$message = str_replace('{password}', $data['password_text'], $message);
		$message = str_replace('{business_name}', $info['name'], $message);
		$message = str_replace('{login_url}', $site_link, $message);

		$mailer = new Mailer();
		$useornot = $mailer->getData();
		if (!$useornot) {
			$mailer->mail->setFrom($info['email'], $info['name']);
		}
		$mailer->mail->addAddress($data['email'], $data['firstname']);
		$mailer->mail->isHTML(true);
		$mailer->mail->Subject = $template['subject'];
		$mailer->mail->Body = html_entity_decode($message);
		$mailer->mail->AltBody = 'Hello '.$data['firstname'].'.
		Welcome to '.URL. PHP_EOL.' Your account has been created. Your password - '.$data['password'].' ';
		$mailer->sendMail();
	}

	/**
	* Delete Function or method
	* This function is going to delete user from database
	**/
	protected function delete()
	{
		$result = $this->userModel->deleteUser($this->url->post('id'));
		$this->session->data['message'] = array('alert' => 'success', 'value' => 'Account deleted successfully.');
		$this->url->redirect('user');
	}
	/**
	* Validate user field from server side
	**/
	protected function validateField()
	{
		$error = [];
		$error_flag = false;
		if ($this->commons->validateText($this->url->post('user')['firstname'])) {
			$error_flag = true;
			$error['firstname'] = 'First Name';
		}
		if ($this->commons->validateText($this->url->post('user')['lastname'])) {
			$error_flag = true;
			$error['lastname'] = 'Last Name';
		}
		if ($this->commons->validateText($this->url->post('user')['username'])) {
			$error_flag = true;
			$error['username'] = 'Username';
		}
		if ($this->commons->validateEmail($this->url->post('user')['email'])) {
			$error_flag = true;
			$error['email'] = 'Email Address';
		}
		if ($this->commons->validatePhoneNumber($this->url->post('user')['mobile'])) {
			$error_flag = true;
			$error['mobile'] = 'Mobile Number';
		}
		if ($error_flag) {
			return $error;
		} else {
			return false;
		}
	}

	public function userRole()
	{
		$this->commons->isAdmin();

		/*Get User name and role*/
		$data = $this->commons->getUser();

		/*Load Language File*/
		require DIR_BUILDER.'language/'.$data['info']['language'].'/common.php';
		$data['lang']['common'] = $lang;
		require DIR_BUILDER.'language/'.$data['info']['language'].'/users.php';
		$data['lang']['users'] = $users;

		$data['result'] = $this->userModel->getRoles();

		$data['page_title'] = $data['lang']['common']['text_user_roles'];

		/*Render User list view*/
		$this->view->render('user/user_role.tpl', $data);
	}

	public function userRoleAdd()
	{
		$this->commons->isAdmin();
		/*Get User name and role*/
		$data = $this->commons->getUser();

		/*Load Language File*/
		require DIR_BUILDER.'language/'.$data['info']['language'].'/common.php';
		$data['lang']['common'] = $lang;
		require DIR_BUILDER.'language/'.$data['info']['language'].'/users.php';
		$data['lang']['users'] = $users;

		$data['result'] = NULL;
		
		$data['page_title'] = $data['lang']['users']['text_new_user_role'];
		$data['role'] = array(
			array('contacts' => $data['lang']['users']['text_contact_list'],
				'contact/add' => $data['lang']['users']['text_contact_add'],
				'contact/edit' => $data['lang']['users']['text_contact_edit'],
				'contact/delete' => $data['lang']['users']['text_contact_delete'],
				'contact/view' => $data['lang']['users']['text_contact_view']),
			array('leads' => $data['lang']['users']['text_lead_list'],
				'lead/add' => $data['lang']['users']['text_lead_add'],
				'lead/edit' => $data['lang']['users']['text_lead_edit'],
				'lead/delete' => $data['lang']['users']['text_lead_delete'],
				'' => ''),
			array('projects' => $data['lang']['users']['text_project_list'],
				'project/add' => $data['lang']['users']['text_project_add'],
				'project/edit' => $data['lang']['users']['text_project_edit'],
				'project/delete' => $data['lang']['users']['text_project_delete'],
				'' => ''),
			array('quotes' => $data['lang']['users']['text_quote_list'],
				'quote/add' => $data['lang']['users']['text_quote_add'],
				'quote/edit' => $data['lang']['users']['text_quote_edit'],
				'quote/delete' => $data['lang']['users']['text_quote_delete'],
				'quote/view' => $data['lang']['users']['text_quote_view']),
			array('invoices' => $data['lang']['users']['text_invoice_list'],
				'invoice/add' => $data['lang']['users']['text_invoice_add'],
				'invoice/edit' => $data['lang']['users']['text_invoice_edit'],
				'invoice/delete' => $data['lang']['users']['text_invoice_delete'],
				'invoice/view' => $data['lang']['users']['text_invoice_view']),
			array('recurring' => $data['lang']['users']['text_recurring_invoice_list'],
				'recurring/add' => $data['lang']['users']['text_recurring_invoice_add'],
				'recurring/edit' => $data['lang']['users']['text_recurring_invoice_edit'],
				'recurring/delete' => $data['lang']['users']['text_recurring_invoice_delete'],
				'recurring/view' => $data['lang']['users']['text_recurring_invoice_view']),
			array('tickets' => $data['lang']['users']['text_ticket_list'],
				'ticket/add' => $data['lang']['users']['text_ticket_add'],
				'ticket/edit' => $data['lang']['users']['text_ticket_edit'],
				'ticket/delete' => $data['lang']['users']['text_ticket_delete'],
				'' => ''),
			array('domains' => $data['lang']['users']['text_domain_list'],
				'domain/add' => $data['lang']['users']['text_domain_add'],
				'domain/edit' => $data['lang']['users']['text_domain_edit'],
				'domain/delete' => $data['lang']['users']['text_domain_delete'],
				'' => ''),
			array('expenses' => $data['lang']['users']['text_expense_list'],
				'expense/add' => $data['lang']['users']['text_expense_add'],
				'expense/edit' => $data['lang']['users']['text_expense_edit'],
				'expense/delete' => $data['lang']['users']['text_expense_delete'],
				'' => ''),
			array('users' => $data['lang']['users']['text_user_list'],
				'user/add' => $data['lang']['users']['text_user_add'],
				'user/edit' => $data['lang']['users']['text_user_edit'],
				'user/delete' => $data['lang']['users']['text_user_delete'],
				'' => ''),
			array('subscriber' => $data['lang']['users']['text_subscriber_list'],
				'subscriber/add' => $data['lang']['users']['text_subscriber_add'],
				'subscriber/edit' => $data['lang']['users']['text_subscriber_edit'],
				'subscriber/delete' => $data['lang']['users']['text_subscriber_delete'],
				'' => '')
		);
		$data['role_selected'] = array();

		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);
		$data['action'] = URL.DIR_ROUTE.'role/action';
		/*Render User list view*/
		
		$this->view->render('user/user_role_form.tpl', $data);
	}

	public function userRoleEdit()
	{
		$this->commons->isAdmin();
		/**
		* Check if id exist in url if not exist then redirect to User list view 
		**/
		$id = (int)$this->url->get('id');
		if (empty($id) || !is_int($id)) {
			$this->url->redirect('role');
		}

		if ($id == "1") {
			$this->session->data['message'] = array('alert' => 'warning', 'value' => 'You can not change Admin role setting.');
			$this->url->redirect('role');
		}

		/*Get User name and role*/
		$data = $this->commons->getUser();
		
		/*Load Language File*/
		require DIR_BUILDER.'language/'.$data['info']['language'].'/common.php';
		$data['lang']['common'] = $lang;
		require DIR_BUILDER.'language/'.$data['info']['language'].'/users.php';
		$data['lang']['users'] = $users;

		$data['result'] = $this->userModel->getRole($id);
		$data['role'] = array(
			array('contacts' => $data['lang']['users']['text_contact_list'],
				'contact/add' => $data['lang']['users']['text_contact_add'],
				'contact/edit' => $data['lang']['users']['text_contact_edit'],
				'contact/delete' => $data['lang']['users']['text_contact_delete'],
				'contact/view' => $data['lang']['users']['text_contact_view']),
			array('leads' => $data['lang']['users']['text_lead_list'],
				'lead/add' => $data['lang']['users']['text_lead_add'],
				'lead/edit' => $data['lang']['users']['text_lead_edit'],
				'lead/delete' => $data['lang']['users']['text_lead_delete'],
				'' => ''),
			array('projects' => $data['lang']['users']['text_project_list'],
				'project/add' => $data['lang']['users']['text_project_add'],
				'project/edit' => $data['lang']['users']['text_project_edit'],
				'project/delete' => $data['lang']['users']['text_project_delete'],
				'' => ''),
			array('quotes' => $data['lang']['users']['text_quote_list'],
				'quote/add' => $data['lang']['users']['text_quote_add'],
				'quote/edit' => $data['lang']['users']['text_quote_edit'],
				'quote/delete' => $data['lang']['users']['text_quote_delete'],
				'quote/view' => $data['lang']['users']['text_quote_view']),
			array('invoices' => $data['lang']['users']['text_invoice_list'],
				'invoice/add' => $data['lang']['users']['text_invoice_add'],
				'invoice/edit' => $data['lang']['users']['text_invoice_edit'],
				'invoice/delete' => $data['lang']['users']['text_invoice_delete'],
				'invoice/view' => $data['lang']['users']['text_invoice_view']),
			array('recurring' => $data['lang']['users']['text_recurring_invoice_list'],
				'recurring/add' => $data['lang']['users']['text_recurring_invoice_add'],
				'recurring/edit' => $data['lang']['users']['text_recurring_invoice_edit'],
				'recurring/delete' => $data['lang']['users']['text_recurring_invoice_delete'],
				'recurring/view' => $data['lang']['users']['text_recurring_invoice_view']),
			array('tickets' => $data['lang']['users']['text_ticket_list'],
				'ticket/add' => $data['lang']['users']['text_ticket_add'],
				'ticket/edit' => $data['lang']['users']['text_ticket_edit'],
				'ticket/delete' => $data['lang']['users']['text_ticket_delete'],
				'' => ''),
			array('domains' => $data['lang']['users']['text_domain_list'],
				'domain/add' => $data['lang']['users']['text_domain_add'],
				'domain/edit' => $data['lang']['users']['text_domain_edit'],
				'domain/delete' => $data['lang']['users']['text_domain_delete'],
				'' => ''),
			array('expenses' => $data['lang']['users']['text_expense_list'],
				'expense/add' => $data['lang']['users']['text_expense_add'],
				'expense/edit' => $data['lang']['users']['text_expense_edit'],
				'expense/delete' => $data['lang']['users']['text_expense_delete'],
				'' => ''),
			array('users' => $data['lang']['users']['text_user_list'],
				'user/add' => $data['lang']['users']['text_user_add'],
				'user/edit' => $data['lang']['users']['text_user_edit'],
				'user/delete' => $data['lang']['users']['text_user_delete'],
				'' => ''),
			array('subscriber' => $data['lang']['users']['text_subscriber_list'],
				'subscriber/add' => $data['lang']['users']['text_subscriber_add'],
				'subscriber/edit' => $data['lang']['users']['text_subscriber_edit'],
				'subscriber/delete' => $data['lang']['users']['text_subscriber_delete'],
				'' => '')
		);
		$data['role_selected'] = json_decode($data['result']['permission'], true);
		
		$data['page_title'] = $data['lang']['users']['text_edit_user_role'];
		
		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);
		$data['action'] = URL.DIR_ROUTE.'role/action';
		/*Render User list view*/
		$this->view->render('user/user_role_form.tpl', $data);
	}

	public function userRoleAction()
	{
		$this->commons->isAdmin();
		/**
		* Check if from is submitted or not 
		**/
		if (!isset($_POST['submit'])) {
			$this->url->redirect('role');
			exit();
		}
		if ($this->commons->validateToken($this->url->post('_token'))){
			
		}

		if (!empty($this->url->post('id'))) {
			$data['name'] = $this->url->post('name');
			$data['description'] = $this->url->post('description');
			$data['id'] = $this->url->post('id');
			$data['permission'] = json_encode($this->url->post('role'));
			
			$result = $this->userModel->updateUserRole($data);
			$this->url->redirect('role/edit&id='.$data['id']);

		} else {
			$data['name'] = $this->url->post('name');
			$data['description'] = $this->url->post('description');
			$data['permission'] = json_encode($this->url->post('role'));

			$result = $this->userModel->addUserRole($data);
			$this->url->redirect('role/edit&id='.$result);
		}
	}

	public function userRoleDelete()
	{
		$this->commons->isAdmin();
		$result = $this->userModel->deleteRole($this->url->post('id'));
		$this->session->data['message'] = array('alert' => 'success', 'value' => 'User Role deleted successfully.');
		$this->url->redirect('role');
	}
}