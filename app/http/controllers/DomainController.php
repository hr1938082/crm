<?php

/**
* DomainController
*/
class DomainController extends Controller
{
	private $domainModel;
	function __construct()
	{
		parent::__construct();
		$this->commons = new CommonsController();
		/*Intilize User model*/
		$this->domainModel = new Domain();
	}

	public function index()
	{
		if (!$this->commons->hasPermission('domains')) {
			Not_foundController::show('403');
			exit();
		}
		
		/*Get User name and role*/
		$data = $this->commons->getUser();
		/**
		* Get all User data from DB using User model 
		**/
		if ($user = $this->commons->checkUser()) {
			$data['result'] = $this->domainModel->getDomains($user);
		} else {
			$data['result'] = $this->domainModel->getDomains();
		}

		if (!empty($data['result'])) {
			foreach ($data['result'] as $key => $value) {
				$temp = new DateTime($value['expiry_date']);
				$current = new DateTime();
				$temp->modify('-1 month');

				if(strtotime($temp->format('Y-m-d')) < strtotime($current->format('Y-m-d'))) {
					$data['result'][$key]['expire'] = 1;
				} else {
					$data['result'][$key]['expire'] = 0;
				}
			}
		}

		/*Load Language File*/
		require DIR_BUILDER.'language/'.$data['info']['language'].'/common.php';
		$data['lang']['common'] = $lang;
		require DIR_BUILDER.'language/'.$data['info']['language'].'/domain.php';
		$data['lang']['domain'] = $domain;

		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}

		/* Set page title */
		$data['page_title'] = $data['lang']['domain']['text_domains'];
		
		/*Render User list view*/
		$this->view->render('domain/domain_list.tpl', $data);
	}

	public function indexAdd()
	{
		if (!$this->commons->hasPermission('domain/add')) {
			Not_foundController::show('403');
			exit();
		}
		
		/*Get User name and role*/
		$data = $this->commons->getUser();
		/**
		* Get all User data from DB using User model 
		**/
		$data['result'] = NULL;

		if ($user = $this->commons->checkUser()) {
			$data['user']['user_id'] = $this->session->data['user_id'];
			$data['admin'] = false;
			$data['customers'] = $this->domainModel->getCustomers($user);
		} else {
			$data['admin'] = true;
			$data['customers'] = $this->domainModel->getCustomers();
		}

		$data['currency'] = $this->domainModel->getCurrency();
		/*Load Language File*/
		require DIR_BUILDER.'language/'.$data['info']['language'].'/common.php';
		$data['lang']['common'] = $lang;
		require DIR_BUILDER.'language/'.$data['info']['language'].'/domain.php';
		$data['lang']['domain'] = $domain;

		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}

		$data['action'] = URL.DIR_ROUTE.'domain/action';
		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);

		/* Set page title */
		$data['page_title'] = $data['lang']['domain']['text_add_domain'];
		
		/*Render User list view*/
		$this->view->render('domain/domain_form.tpl', $data);
	}

	public function indexEdit()
	{
		if (!$this->commons->hasPermission('domain/edit')) {
			Not_foundController::show('403');
			exit();
		}
		/**
		* Check if id exist in url if not exist then redirect to Item list view 
		**/
		$id = (int)$this->url->get('id');
		if (empty($id) || !is_int($id)) {
			$this->url->redirect('domains');
		}
		/*Get User name and role*/
		$data = $this->commons->getUser();
		/**
		* Get all User data from DB using User model 
		**/

		if ($user = $this->commons->checkUser()) {
			$data['customers'] = $this->domainModel->getCustomers($user);
			$data['result'] = $this->domainModel->getDomain($id, $user);
		} else {
			$data['customers'] = $this->domainModel->getCustomers();
			$data['result'] = $this->domainModel->getDomain($id);
		}

		if (empty($data['result'])) {
			$this->url->redirect('domains');
		}

		$data['currency'] = $this->domainModel->getCurrency();

		/*Load Language File*/
		require DIR_BUILDER.'language/'.$data['info']['language'].'/common.php';
		$data['lang']['common'] = $lang;
		require DIR_BUILDER.'language/'.$data['info']['language'].'/domain.php';
		$data['lang']['domain'] = $domain;


		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}
		/* Set page title */
		$data['page_title'] = $data['lang']['domain']['text_edit_domain'];
		$data['action'] = URL.DIR_ROUTE.'domain/action';
		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);

		/*Render User list view*/

		$this->view->render('domain/domain_form.tpl', $data);
	}

	public function indexAction()
	{
		/**
		* Check if from is submitted or not 
		**/
		if (!isset($_POST['submit'])) {
			$this->url->redirect('domains');
			exit();
		}
		
		if ($this->commons->validateToken($this->url->post('_token'))) {
			$this->session->data['message'] = array('alert' => 'warning', 'value' => 'Token does not match!');
			$this->url->redirect('contacts');
		}

		if (!empty($this->url->post('id'))) {
			$data = $this->url->post('domain');
			$data['id'] = $this->url->post('id');
			$data['renew'] = isset($data['renew']) ? $data['renew'] : '0';
			$data['registration_date'] = date_format(date_create($data['r_date']), 'Y-m-d');
			$data['expiry_date'] = date_format(date_create($data['e_date']), 'Y-m-d');

			$result = $this->domainModel->updateDomain($data);

			$this->url->redirect('domain/edit&id='.$data['id']);
		}
		else {
			$data = $this->url->post('domain');
			$data['renew'] = isset($data['renew']) ? $data['renew'] : '0';
			$data['registration_date'] = date_format(date_create($data['r_date']), 'Y-m-d');
			$data['expiry_date'] = date_format(date_create($data['e_date']), 'Y-m-d');
			$result = $this->domainModel->createDomain($data);

			$this->session->data['message'] = array('alert' => 'success', 'value' => 'Domain created successfully.');
			$this->url->redirect('domain/edit&id='.$result);
		}
	}

	public function indexDelete()
	{
		if (!$this->commons->hasPermission('domain/delete')) {
			Not_foundController::show('403');
			exit();
		}
		$result = $this->domainModel->deleteDomain($this->url->post('id'));
		$this->session->data['message'] = array('alert' => 'success', 'value' => 'Domain deleted successfully.');
		$this->url->redirect('domains');
	}
}