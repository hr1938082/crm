<?php

/**
* ItemController
*/
class ItemsController extends Controller
{
	private $itemsModel;
	function __construct()
	{
		parent::__construct();
		$this->commons = new CommonsController();
		/*Intilize User model*/
		$this->itemsModel = new Items();
	}
	/**
	* Item index method
	* This method will be called on Items list view
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
		* Get all User data from DB using User model 
		**/

		$data['result'] = $this->itemsModel->getItems();

		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}
		/* Set page title */
		$data['page_title'] = $data['lang']['common']['text_items'];
		
		/*Render User list view*/
		$this->view->render('items/items_list.tpl', $data);
	}
	/**
	* Item index ADD method
	* This method will be called on Item ADD view
	**/
	public function indexAdd()
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
		* Get all User data from DB using User model 
		**/

		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}
		$data['result'] = NULL;
		$data['currency'] = $this->itemsModel->getCurrency();
		
		/* Set page title */
		$data['page_title'] = $data['lang']['settings']['text_new_item'];
		$data['action'] = URL.DIR_ROUTE.'item/action';
		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);

		/*Render User list view*/
		$this->view->render('items/items_form.tpl', $data);
	}
	/**
	* Item index Edit method
	* This method will be called on Item Edit view
	**/
	public function indexEdit()
	{
		$this->commons->isAdmin();
		/**
		* Check if id exist in url if not exist then redirect to Item list view 
		**/
		$id = (int)$this->url->get('id');
		if (empty($id) || !is_int($id)) {
			$this->url->redirect('items');
		}
		/*Get User name and role*/
		$data = $this->commons->getUser();

		/*Load Language File*/
		require DIR_BUILDER.'language/'.$data['info']['language'].'/common.php';
		$data['lang']['common'] = $lang;
		require DIR_BUILDER.'language/'.$data['info']['language'].'/settings.php';
		$data['lang']['settings'] = $settings;

		/**
		* Get all User data from DB using User model 
		**/

		$data['result'] = $this->itemsModel->getItem($id);
		
		if (empty($data['result'])) {
			$this->url->redirect('items');
		}
	
		$data['currency'] = $this->itemsModel->getCurrency();
		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}
		/* Set page title */
		$data['page_title'] = $data['lang']['settings']['text_edit_item'];
		$data['action'] = URL.DIR_ROUTE.'item/action';
		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);

		/*Render User list view*/
		$this->view->render('items/items_form.tpl', $data);
	}
	/**
	* Item index Action method
	* This method will be called on Item Save or Update view
	**/
	public function indexAction()
	{
		$this->commons->isAdmin();
		/**
		* Check if from is submitted or not 
		**/
		if (!isset($_POST['submit'])) {
			$this->url->redirect('items');
			exit();
		}
		/**
		* Validate form data
		* If some data is missing or data does not match pattern
		* Return to info view 
		**/
		if ($validate_field = $this->validateField()) {
			$this->session->data['message'] = array('alert' => 'error', 'value' => 'Please enter valid '.implode(", ",$validate_field).'!');
			$this->url->redirect('items');
		}

		if ($this->commons->validateToken($this->url->post('_token'))) {
			$this->url->redirect('items');
		}

		if (!empty($this->url->post('id'))) {
			$result = $this->itemsModel->updateItem($this->url->post);
			$this->session->data['message'] = array('alert' => 'success', 'value' => 'Item updated successfully.');
			$this->url->redirect('item/edit&id='.$this->url->post('id'));
		}
		else {
			$result = $this->itemsModel->createItem($this->url->post);
			$this->session->data['message'] = array('alert' => 'success', 'value' => 'Item created successfully.');
			$this->url->redirect('item/edit&id='.$result);
		}
	}
	/**
	* Item index Delete method
	* This method will be called on Item Delete view
	**/
	public function indexDelete()
	{
		$this->commons->isAdmin();
		$result = $this->itemsModel->deleteItem($this->url->post('id'));
		$this->session->data['message'] = array('alert' => 'success', 'value' => 'Item deleted successfully.');
		$this->url->redirect('items');
	}
	/**
	* Item validate method
	* This method will be called to validate input field 
	**/
	public function validateField()
	{
		$error = [];
		$error_flag = false;

		if ($this->commons->validateNumeric($this->url->post('type'))) {
			$error_flag = true;
			$error['author'] = 'Item Type!';
		}
		if ($this->commons->validateText($this->url->post('name'))) {
			$error_flag = true;
			$error['title'] = 'Item Name!';
		}

		if ($this->commons->validateNumeric($this->url->post('price'))) {
			$error_flag = true;
			$error['author'] = 'Item Rate!';
		}
		
		if ($error_flag) {
			return $error;
		} else {
			return false;
		}
	}
}