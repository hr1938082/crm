<?php

/**
* CalendarController
*/
class CalendarController extends Controller
{
	private $calendarModel;
	function __construct()
	{
		parent::__construct();
		$this->commons = new CommonsController();
		/*Intilize User model*/
		$this->calendarModel = new Calendar();
	}

	/**
	* Calendar index method
	* This method will be called on Calendar view
	**/
	public function index()
	{
		
		/*Get User name and role*/
		$data = $this->commons->getUser();

		/**
		* Get all Event data from DB using Event model
		* According to user_role 
		**/
		
		if ($this->session->data['role'] == "1") {
			$data['result'] = json_encode($this->calendarModel->getEvents());
		} else {
			$data['result'] = json_encode($this->calendarModel->getUserEvents($this->session->data['user_id']));
		}

		/*Load Language File*/
		require DIR_BUILDER.'language/'.$data['info']['language'].'/common.php';
		$data['lang']['common'] = $lang;
		require DIR_BUILDER.'language/'.$data['info']['language'].'/calendar.php';
		$data['lang']['calendar'] = $calendar;

		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}

		/* Set Page title and action */
		$data['page_title'] = $data['lang']['calendar']['text_events'];
		$data['action'] = URL.DIR_ROUTE.'calendar/action';

		/*Render Calendar list view*/
		$this->view->render('calendar/calendar.tpl', $data);
	}
	/**
	* Calendar index Action method
	* This method will be called on Event add or Update.
	**/
	public function indexAction()
	{
		/**
		* Check if form is submitted or not 
		**/
		if (!isset($_POST['submit'])) {
			$this->url->redirect('calendar');
			exit();
		}
		/**
		* Validate form data
		* If some data is missing or data does not match pattern
		* Return to Calendar view 
		**/
		if ($validate_field = $this->validateField()) {
			$this->session->data['message'] = array('alert' => 'error', 'value' => 'Please enter valid '.implode(", ",$validate_field).'!');
			$this->url->redirect('calendar');
		}

		if (!empty($this->url->post('id'))) {
			$data = $this->url->post('event');
			$data['allday'] = isset($data['allday']) ? true : false;
			$data['user_id'] = $this->session->data['user_id'];
			$data['start'] = date_format(date_create($data['start']), 'Y-m-d H:i:s');
			if ($data['allday']) {
				$date = new DateTime($data['start']);
				$date->setTime(23,59);
				$data['end'] = date_format($date, 'Y-m-d H:i:s');
			} else {
				$data['end'] = date_format(date_create($data['end']), 'Y-m-d H:i:s');
			}
			$data['id'] = $this->url->post('id');

			/*Update Event*/
			$result = $this->calendarModel->updateEvent($data);
			$this->session->data['message'] = array('alert' => 'success', 'value' => 'Calendar Event updated successfully.');
			$this->url->redirect('calendar');

		} else {
			$data = $this->url->post('event');
			$data['allday'] = isset($data['allday']) ? true : false;
			$data['user_id'] = $this->session->data['user_id'];
			$data['start'] = date_format(date_create($data['start']), 'Y-m-d H:i:s');
			if ($data['allday']) {
				$date = new DateTime($data['start']);
				$date->setTime(23,59);
				$data['end'] = date_format($date, 'Y-m-d H:i:s');
			} else {
				$data['end'] = date_format(date_create($data['end']), 'Y-m-d H:i:s');
			}
			/*Create Calendar*/
			$result = $this->calendarModel->createEvent($data);
			$this->session->data['message'] = array('alert' => 'success', 'value' => 'Calendar Event created successfully.');
			$this->url->redirect('calendar');
		}
	}
	/**
	* Calendar index Drop method
	* This method will be called on cjhange event date
	**/
	public function indexDrop()
	{
		$data = $this->url->post;
		$data['start'] = date_format(date_create($data['start']), 'Y-m-d g:i A');
		$result = $this->calendarModel->dropEvent($data);
		echo "1";
	}
	/**
	* Calendar index Delete method
	* This method will be called on Event delete
	**/
	public function indexDelete()
	{
		$result = $this->calendarModel->deleteEvent($this->url->post('id'));
		$this->session->data['message'] = array('alert' => 'success', 'value' => 'Event deleted successfully.');
		$this->url->redirect('calendar');
	}
	
	/*Validate Event Input Filed*/
	public function validateField()
	{
		$error = [];
		$error_flag = false;

		if ($this->commons->validateText($this->url->post('event')['title'])) {
			$error_flag = true;
			$error['name'] = 'Event Name!';
		}
		
		if ($error_flag) {
			return $error;
		} else {
			return false;
		}
	}
}