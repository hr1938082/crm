<?php

use Sabberworm\CSS\Value\URL;

/**
* LeadController
*/
class LeadController extends Controller
{
	private $leadModel;
	private $contactModel;
	private $website;
	function __construct()
	{
		parent::__construct();
		$this->commons = new CommonsController();
		/*Intilize User model*/
		$this->leadModel = new Lead();
		$this->website = new WebClient();
		$this->contactModel = new Contact();
	}
	public function index()
	{
		if (!$this->commons->hasPermission('leads')) {		
			Not_foundController::show('403');
			exit();
		}
		
		
		/*Get User name and role*/
		$data = $this->commons->getUser();
		$data['websites'] = $this->website->selectWebClient();
		var_dump(true);
		/**
		* Get all User data from DB using User model 
		**/
		if ($user_id = $this->commons->checkUser()) {
			$data['user']['user_id'] = $this->session->data['user_id'];
			$data['admin'] = false;
			$data['result'] = $this->leadModel->getLeads($user_id);
		    
		} else {
			$data['admin'] = true;
			
			$search = $this->url->get('search');
			$website_id = $this->url->get('website');
			if($search != "")
			{	
				if($website_id != "")
				{
					$data['result'] = $this->leadModel->getLeads(null,$search, $website_id);
				}
				else
				{
					$data['result'] = $this->leadModel->getLeads(null,$search);
				}
			}
			else
			{
				$data['result'] = $this->leadModel->getLeads($user_id);
			}
			$data['website'] = $this->website->selectWebClient();
		}
		/*Load Language File*/
		require DIR_BUILDER.'language/'.$data['info']['language'].'/common.php';
		$data['lang']['common'] = $lang;
		require DIR_BUILDER.'language/'.$data['info']['language'].'/contact.php';
		$data['lang']['contact'] = $contact;

		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}
		/* Set page title */
		$data['page_title'] = $data['lang']['common']['text_leads'];
			$data['staff'] = $this->leadModel->getStaff();
	 	/*Render User list view*/
	 	$data['action'] = URL.DIR_ROUTE.'/leads/action_assign';
		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);
		$this->view->render('contact/leads_list.tpl',$data);
	}

	public function indexAdd(){
	    
		if (!$this->commons->hasPermission('lead/add')) {
			Not_foundController::show('403');
			exit();
		}
		
		/*Get User name and role*/
		$data = $this->commons->getUser();
		/**
		* Get all User data from DB using User model 
		**/
		$data['result'] = NULL;

		if ($user_id = $this->commons->checkUser()) {
			$data['user']['user_id'] = $this->session->data['user_id'];
			$data['admin'] = false;
		} else {
			$data['admin'] = true;
			$data['staff'] = $this->leadModel->getStaff();
			$data['websites'] = $this->website->selectWebClient();
		}
		/*Load Language File*/
		require DIR_BUILDER.'language/'.$data['info']['language'].'/common.php';
		$data['lang']['common'] = $lang;
		require DIR_BUILDER.'language/'.$data['info']['language'].'/contact.php';
		$data['lang']['contact'] = $contact;

		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}
		/* Set page title */
		$data['page_title'] = $data['lang']['contact']['text_add_lead'];
		$data['action'] = URL.DIR_ROUTE.'lead/action';
		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);
		/*Render User list view*/
		$this->view->render('contact/lead_form.tpl', $data);
	}

	public function indexEdit()
	{
	     
		if (!$this->commons->hasPermission('lead/edit')) {
			Not_foundController::show('403');
			exit();
		}
		/**
		* Check if id exist in url if not exist then redirect to Item list view 
		**/
		$id = (int)$this->url->get('id');
		if (empty($id) || !is_int($id)) {
			$this->url->redirect('leads');
		}
		
		/*Get User name and role*/
		$data = $this->commons->getUser();
		/**
		* Get all User data from DB using User model 
		**/

		if ($user = $this->commons->checkUser()) {
		    
			$data['user']['user_id'] = $this->session->data['user_id'];
			$data['admin'] = false;
			$data['result'] = $this->leadModel->getLeads($id, $user);
			
			
		} else {
			$data['admin'] = true;
			$data['result'] = $this->leadModel->getLead($id);
			$data['staff'] = $this->leadModel->getStaff();
			$data['websites'] = $this->website->selectWebClient();
		}

		if (empty($data['result'])) {
			$this->session->data['message'] = array('alert' => 'warning', 'value' => 'Leads does not exist in database.');
			$this->url->redirect('leads');
		}

		$data['result']['address'] = json_decode($data['result']['address'], true);
		$data['result']['marketing'] = json_decode($data['result']['marketing'], true);

		/*Load Language File*/
		require DIR_BUILDER.'language/'.$data['info']['language'].'/common.php';
		$data['lang']['common'] = $lang;
		require DIR_BUILDER.'language/'.$data['info']['language'].'/contact.php';
		$data['lang']['contact'] = $contact;

		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}
		/* Set page title */
		$data['page_title'] = $data['lang']['contact']['text_edit_lead'];
		$data['action'] = URL.DIR_ROUTE.'lead/action';
		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);
		/*Render User list view*/
	   	$this->view->render('contact/lead_form.tpl', $data);
	}
	
	
	public function assign_user($id = null){
	   
	   if (!empty($this->url->post('id'))) {
		$data = $this->url->post('contact');
		 $data['staff_ff'] = $this->url->post('staff_ff');
		 	$result = $this->leadModel->update_assign_list($data);
		
				$this->session->data['message'] = array('alert' => 'success', 'value' => 'New Staff Assign Successfully.');
             $this->url->redirect('lead/convert&id='.$data['id'].'&token='.hash('sha512', TOKEN . TOKEN_SALT) );
	
	   }
			
	    
	}
	
 

	public function indexAction()
	{  
	    
	   
		/**
		* Check if from is submitted or not 
		**/
		if (!isset($_POST['submit'])) {
		   
			$this->url->redirect('leads');
			exit();
		}

		if ($this->commons->validateToken($this->url->post('_token'))) {
			$this->session->data['message'] = array('alert' => 'warning', 'value' => 'Token does not match!');
			$this->url->redirect('leads');
		}
           //  var_dump($this->url->post('id'));
            
		if (!empty($this->url->post('id'))) {
		    
		    
			$data = $this->url->post('contact');
			$data['id'] = $this->url->post('id');
			$data['country'] = $data['address']['country'];
			$data['address'] = json_encode($data['address']);
			$data['expire'] = date_format(date_create($data['expire']), 'Y-m-d');
			$data['website_id'] = $this->url->post('contact')['website_id'];
			$data['marketing']['email'] = isset($data['marketing']['email']) ? $data['marketing']['email']: false;
			$data['marketing']['phone'] = isset($data['marketing']['phone']) ? $data['marketing']['phone']: false;
			$data['marketing']['sms'] = isset($data['marketing']['sms']) ? $data['marketing']['sms']: false;
			$data['marketing']['social'] = isset($data['marketing']['social']) ? $data['marketing']['social']: false;
			$data['marketing'] = json_encode($data['marketing']);
			 $data['id'];
			$result = $this->leadModel->updateLead($data);
			$this->session->data['message'] = array('alert' => 'success', 'value' => 'Leads updated successfully.');
            $this->url->redirect('lead/convert&id='.$data['id'].'&token='.hash('sha512', TOKEN . TOKEN_SALT) );
		}
		else {
			$data = $this->url->post('contact');
		 
			
			$data['country'] = $data['address']['country'];
			$data['address'] = json_encode($data['address']);
			$data['expire'] = date_format(date_create($data['expire']), 'Y-m-d');
			$data['website_id'] = $this->url->post('contact')['website_id'];
			$data['marketing']['email'] = isset($data['marketing']['email']) ? $data['marketing']['email']: false;
			$data['marketing']['phone'] = isset($data['marketing']['phone']) ? $data['marketing']['phone']: false;
			$data['marketing']['sms'] = isset($data['marketing']['sms']) ? $data['marketing']['sms']: false;
			$data['marketing']['social'] = isset($data['marketing']['social']) ? $data['marketing']['social']: false;
			$data['marketing'] = json_encode($data['marketing']);
			
			$result = $this->leadModel->createLead($data);
			$this->session->data['message'] = array('alert' => 'success', 'value' => 'Leads created successfully.');
			//$this->url->redirect('lead/edit&id='.$result);
			$this->url->redirect('lead/convert&id='.$result['id'].'&token='.hash('sha512', TOKEN . TOKEN_SALT) );
		}
	}

	public function convertLead()
	{
		if (!$this->commons->hasPermission('lead/edit')) {
			Not_foundController::show('403');
			exit();
		}
       // die('============================');
		/**
		* Check if id exist in url if not exist then redirect to Item list view 
		**/
		$id = (int)$this->url->get('id');
		if (empty($id) || !is_int($id)) {
			$this->url->redirect('leads');
		}

		if ($this->commons->validateToken($this->url->get('token'))) {
			$this->session->data['message'] = array('alert' => 'warning', 'value' => 'Token does not match!');
			$this->url->redirect('leads');
		}

		$data['result'] = $this->leadModel->getLead($id);
		
		if (empty($data['result'])) {
			$this->session->data['message'] = array('alert' => 'warning', 'value' => 'Leads does not exist in database.');
			$this->url->redirect('leads');
		}
		$address = json_decode($data['result']['address'], true);
		$address['phone1'] = '';
		$address['fax'] = '';
		$data['result']['address'] = json_encode($address);

		$result = $this->leadModel->convertLeadToContact($data['result']);

		$this->session->data['message'] = array('alert' => 'success', 'value' => 'Contact created successfully.');
		$this->url->redirect('contact/edit&id='.$result);
	}
	/**
	* lead index Delete method
	* This method will be called on lead Delete view
	**/
	public function indexDelete()
	{
		// var_dump($this->url->post);
		// die;
		if (!$this->commons->hasPermission('lead/delete')) {
			Not_foundController::show('403');
			exit();
		}
		$delete =$this->url->post('delete');
		if($delete)
		{
			foreach($delete as $id)
			{
				$this->leadModel->deleteLead($id);
				
				$this->contactModel->deleteContactByLead($id);
			}
		}
		else
		{
			$result = $this->leadModel->deleteLead($this->url->post('id'));
			
			$this->contactModel->deleteContactByLead($this->url->post('id'));
		}
		$this->session->data['message'] = array('alert' => 'success', 'value' => 'Lead deleted successfully.');
		$this->url->redirect('leads');
	}
}