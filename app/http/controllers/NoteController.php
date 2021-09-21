<?php

/**
* NoteController
*/
class NoteController extends Controller
{
	private $noteModel;
	function __construct()
	{
		parent::__construct();
		$this->commons = new CommonsController();
		/*Intilize User model*/
		$this->noteModel = new Note();
	}
	/**
	* Note index method
	* This method will be called on Note list view
	**/
	public function index()
	{
		/*Get User name and role*/
		$data = $this->commons->getUser();

		/*Load Language File*/
		require DIR_BUILDER.'language/'.$data['info']['language'].'/common.php';
		$data['lang']['common'] = $lang;
		require DIR_BUILDER.'language/'.$data['info']['language'].'/notes.php';
		$data['lang']['notes'] = $notes;

		/**
		* Get all Notes from DB using Note model 
		**/
		if ($this->session->data['role'] == "1") {
			$data['result'] = $this->noteModel->getNotes();
		} else {
			$data['result'] = $this->noteModel->getUserNotes($this->session->data['user_id']);
		}
		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}
		/* Set page title */
		$data['page_title'] = $data['lang']['common']['text_notes'];

		/*Render User list view*/
		$this->view->render('note/note_list.tpl', $data);
	}
	/**
	* Note index ADD method
	* This method will be called on Note ADD view
	**/
	public function indexAdd()
	{
		/*Get User name and role*/
		$data = $this->commons->getUser();

		/*Load Language File*/
		require DIR_BUILDER.'language/'.$data['info']['language'].'/common.php';
		$data['lang']['common'] = $lang;
		require DIR_BUILDER.'language/'.$data['info']['language'].'/notes.php';
		$data['lang']['notes'] = $notes;

		/**
		* Get all User data from DB using User model 
		**/
		$data['result'] = NULL;
		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}
		/* Set page title */
		$data['page_title'] = $data['lang']['notes']['text_new_note'];
		$data['action'] = URL.DIR_ROUTE.'note/action';
		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);

		/*Render User list view*/
		$this->view->render('note/note_form.tpl', $data);
	}
	/**
	* Note index Edit method
	* This method will be called on Note Edit view
	**/
	public function indexEdit()
	{
		/**
		* Check if id exist in url if not exist then redirect to Item list view 
		**/
		$id = (int)$this->url->get('id');
		if (empty($id) || !is_int($id)) {
			$this->url->redirect('notes');
		}
		/*Get User name and role*/
		$data = $this->commons->getUser();
		/**
		* Get all User data from DB using User model 
		**/
		if ($this->session->data['role'] == "1") {
			$data['result'] = $this->noteModel->getNote($id);
		} else {
			$data['result'] = $this->noteModel->getUserNote($id, $this->session->data['user_id']);
		}
		
		if (empty($data['result'])) {
			$this->url->redirect('notes');
		}

		/*Load Language File*/
		require DIR_BUILDER.'language/'.$data['info']['language'].'/common.php';
		$data['lang']['common'] = $lang;
		require DIR_BUILDER.'language/'.$data['info']['language'].'/notes.php';
		$data['lang']['notes'] = $notes;

		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}

		/* Set page title */
		$data['page_title'] = $data['lang']['notes']['text_edit_note'];
		$data['action'] = URL.DIR_ROUTE.'note/action';
		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);

		/*Render User list view*/
		$this->view->render('note/note_form.tpl', $data);
	}
	/**
	* Note index Action method
	* This method will be called on Note Submit or Save view
	**/
	public function indexAction()
	{
		/**
		* Check if from is submitted or not 
		**/
		if (!isset($_POST['submit'])) {
			$this->url->redirect('notes');
			exit();
		}
		/**
		* Validate form data
		* If some data is missing or data does not match pattern
		* Return to info view 
		**/
		if ($validate_field = $this->validateField()) {
			$this->session->data['message'] = array('alert' => 'error', 'value' => 'Please enter valid '.implode(", ",$validate_field).'!');
			$this->url->redirect('notes');
		}

		if ($this->commons->validateToken($this->url->post('_token'))) {
			$this->url->redirect('contacts');
		}

		if (!empty($this->url->post('id'))) {
			$data = $this->url->post('note');
			$data['id'] = $this->url->post('id');
			$data['user_id'] = $this->session->data['user_id'];
			
			$result = $this->noteModel->updateNote($data);
			$this->session->data['message'] = array('alert' => 'success', 'value' => 'Note updated successfully.');
			$this->url->redirect('note/edit&id='.$data['id']);
		}
		else {
			$data = $this->url->post('note');
			$data['user_id'] = $this->session->data['user_id'];
			$result = $this->noteModel->createNote($data);
			$this->session->data['message'] = array('alert' => 'success', 'value' => 'Note created successfully.');
			$this->url->redirect('note/edit&id='.$result);
		}
	}
	/**
	* Note index Delete method
	* This method will be called on Note Delete view
	**/
	public function indexDelete()
	{
		$result = $this->noteModel->deleteNote($this->url->post('id'));
		$this->session->data['message'] = array('alert' => 'success', 'value' => 'Note deleted successfully.');
		$this->url->redirect('notes');
	}
	/**
	* Valdiate method
	* This method will be called to validate input field
	**/
	public function validateField()
	{
		$error = [];
		$error_flag = false;

		if ($this->commons->validateText($this->url->post('note')['title'])) {
			$error_flag = true;
			$error['author'] = 'Note Title!';
		}
		
		if ($error_flag) {
			return $error;
		} else {
			return false;
		}
	}

}