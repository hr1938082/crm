<?php

/**
* TicketController.php
*/
class TicketController extends Controller
{
	private $ticketModel;
	function __construct()
	{
		parent::__construct();
		$this->commons = new CommonsController();
		/*Intilize User model*/
		$this->ticketModel = new Ticket();
	}

	public function index()
	{
		if (!$this->commons->hasPermission('tickets')) {
			Not_foundController::show('403');
			exit();
		}

		/*Get User name and role*/
		$data = $this->commons->getUser();

		/*Load Language File*/
		require DIR_BUILDER.'language/'.$data['info']['language'].'/common.php';
		$data['lang']['common'] = $lang;
		require DIR_BUILDER.'language/'.$data['info']['language'].'/tickets.php';
		$data['lang']['tickets'] = $tickets;
		/**
		* Get all Tickets from DB using Event model
		* According to @user_role 
		**/
		if (!empty($this->url->get('filter'))) {
			if ($this->url->get('filter') == "open") {
				/* Set page title */
				$data['page_title'] = $data['lang']['tickets']['text_open_tickets'];
				$data['result'] = $this->ticketModel->getOpenTickets();
			} elseif ($this->url->get('filter') == "closed") {
				/* Set page title */
				$data['page_title'] = $data['lang']['tickets']['text_closed_tickets'];
				$data['result'] = $this->ticketModel->getClosedTickets();
			} else {
				/* Set page title */
				$data['page_title'] = $data['lang']['tickets']['text_all_tickets'];
				$data['result'] = $this->ticketModel->getTickets();
			}
		} else {
			/* Set page title */
			$data['page_title'] = $data['lang']['common']['text_tickets'];
			$data['result'] = $this->ticketModel->getTickets();
		}
		$data['ticketCount'] = $this->ticketModel->getTicketCount();

		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}

		/*Render User list view*/
		$this->view->render('ticket/ticket_list.tpl', $data);
	}

	public function indexAdd()
	{
		if (!$this->commons->hasPermission('ticket/add')) {
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
			$data['admin'] = false;
		} else {
			$data['admin'] = true;
			$data['staff'] = $this->ticketModel->getStaff();
		}

		$data['departments'] = $this->ticketModel->getDepartments();

		/*Load Language File*/
		require DIR_BUILDER.'language/'.$data['info']['language'].'/common.php';
		$data['lang']['common'] = $lang;
		require DIR_BUILDER.'language/'.$data['info']['language'].'/tickets.php';
		$data['lang']['tickets'] = $tickets;

		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}
		/* Set page title */
		$data['page_title'] = $data['lang']['tickets']['text_new_ticket'];
		$data['action'] = URL.DIR_ROUTE.'ticket/action';
		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);

		/*Render User list view*/
		$this->view->render('ticket/ticket_form.tpl', $data);
	}

	public function indexEdit()
	{
		if (!$this->commons->hasPermission('ticket/edit')) {
			Not_foundController::show('403');
			exit();
		}
		/**
		* Check if id exist in url if not exist then redirect to Item list view 
		**/
		$id = (int)$this->url->get('id');
		if (empty($id) || !is_int($id)) {
			$this->url->redirect('tickets');
		}
		/*Get User name and role*/
		$data = $this->commons->getUser();

		/*Load Language File*/
		require DIR_BUILDER.'language/'.$data['info']['language'].'/common.php';
		$data['lang']['common'] = $lang;
		require DIR_BUILDER.'language/'.$data['info']['language'].'/tickets.php';
		$data['lang']['tickets'] = $tickets;

		/**
		* Get all User data from DB using User model 
		**/

		if ($user = $this->commons->checkUser()) {
			$data['admin'] = false;
			$data['result'] = $this->ticketModel->getTicket($id, $user);
		} else {
			$data['admin'] = true;
			$data['staff'] = $this->ticketModel->getStaff();
			$data['result'] = $this->ticketModel->getTicket($id);
		}


		if (empty($data['result'])) {
			$this->session->data['message'] = array('alert' => 'warning', 'value' => 'Ticket not found in Database.');
			$this->url->redirect('tickets');
		}

		$data['messages'] = $this->ticketModel->getMessages($id);

		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}
		/* Set page title */
		$data['page_title'] = 'Edit Ticket';
		$data['action'] = URL.DIR_ROUTE.'ticket/action';
		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);

		/*Render User list view*/
		$this->view->render('ticket/ticket_form.tpl', $data);
	}

	public function indexAction()
	{
		/**
		* Check if from is submitted or not 
		**/
		if (!isset($_POST['submit'])) {
			$this->url->redirect('tickets');
			exit();
		}

		if ($this->commons->validateToken($this->url->post('_token'))) {
			$this->url->redirect('tickets');
		}

		if (!empty($this->url->post('id'))) { 
			$data = $this->url->post('ticket');
			$data['attached'] = $this->uplodeFile($_FILES['filename']);
			$data['user_id'] = $this->session->data['user_id'];
			$data['id'] = $this->url->post('id');
			$data['status'] = isset($data['status'])? $data['status']:0;
			$data['last_updated'] = date("Y-m-d h:i:s");

			$result = $this->ticketModel->updateTicket($data);

			if ($data['status'] == '1') {
				$data['template'] = 'closeticket';
			} else {
				$data['template'] = 'ticketresponce';
			}
			$this->ticketUpdateMail($data);

			$this->session->data['message'] = array('alert' => 'success', 'value' => 'Ticket updated successfully.');
			$this->url->redirect('ticket/edit&id='.$data['id']);
		} else {
			$data = $this->url->post('ticket');
			$data['attached'] = $this->uplodeFile($_FILES['filename']);
			$data['user_id'] = $this->session->data['user_id'];
			$data['last_updated'] = date("Y-m-d h:i:s");
			$result = $this->ticketModel->createTicket($data);
			
			$data['id'] = $result;
			$this->newTicketMail($data);
			$this->session->data['message'] = array('alert' => 'success', 'value' => 'Ticket created successfully.');
			$this->url->redirect('ticket/edit&id='.$result);
		}
	}

	public function indexDelete()
	{
		if (!$this->commons->hasPermission('ticket/delete')) {
			Not_foundController::show('403');
			exit();
		}
		$id = $this->url->post('id');
		$data['message'] = $this->ticketModel->getMessages($id);
		
		foreach ($data['message'] as $key => $value) {
			if (!empty($attached = json_decode($value['attached']))) {
				foreach ($attached as $attached_key => $attached_value) {
					if (file_exists('public/uploads/ticket/'.$attached_value)) {
						unlink('public/uploads/ticket/'.$attached_value);
					}
				}
			}
		}

		$data['id'] = $id;
		$data['template'] = 'deleteticket';
		$this->ticketDelete($data);
		$result = $this->ticketModel->deleteTicket($id);
		$this->session->data['message'] = array('alert' => 'success', 'value' => 'Ticket deleted successfully.');
		$this->url->redirect('tickets');
	}

	private function uplodeFile($data)
	{
		$ds = DIRECTORY_SEPARATOR;  
		$storeFolder = 'public/uploads/ticket';
		$file_name_array = array();

		foreach ($data['name'] as $key => $value) {
			$newname = time();
			$rand = rand(100, 999);
			$postfix = date('Ymd');
			
			$ext = pathinfo($value, PATHINFO_EXTENSION);
			$file_name = pathinfo($value, PATHINFO_FILENAME);
			$name = 'Attachment_'.$newname.$rand.'.'.$ext; 
			
			if (!empty($file_name)) {
				$tempFile = $data['tmp_name'][$key];
				
				$targetPath = $storeFolder . $ds;
				$targetFile =  $targetPath. $name;
				move_uploaded_file($tempFile,$targetFile);
				array_push($file_name_array, $name);
				
			}
		}
		
		return json_encode($file_name_array);
	}

	public function downloadFile()
	{
		$file = $this->url->get('name');
		if (empty($file)) {
			$this->url->redirect('closetab');
			exit();
		} else {
			$filepath = DIR."public/uploads/ticket/".$file;

			if(file_exists($filepath)) {
				header('Content-Description: File Transfer');
				header('Content-Type: application/octet-stream');
				header('Content-Disposition: attachment; filename="'.basename($filepath).'"');
				header('Expires: 0');
				header('Cache-Control: must-revalidate');
				header('Pragma: public');
				header('Content-Length: ' . filesize($filepath));
				flush(); 
				readfile($filepath);
				$this->url->redirect('closetab');
			} else {
				$this->url->redirect('closetab');
				exit();
			}
		}
		$this->url->redirect('closetab');
		exit();
	}

	private function newTicketMail($data)
	{
		$info = $this->ticketModel->getInfo();
		$template = $this->ticketModel->getTemplate('newticket');

		$message = $template['message'];
		$ticketurl = '<a href="'.URL_CLIENTS.DIR_ROUTE.'tickets'.'">Tickets</a>';
		$message = str_replace('{SUBJECT}', $data['subject'], $message);
		$message = str_replace('{NAME}', $data['name'], $message);
		$message = str_replace('{ID}', $data['id'], $message);
		$message = str_replace('{EMAIL}', $data['email'], $message);
		$message = str_replace('{MESSAGE}', $data['descr'], $message);
		$message = str_replace('{TICKETURL}', $ticketurl, $message);

		$mailer = new Mailer();
		$useornot = $mailer->getData();
		if (!$useornot) {
			$mailer->mail->setFrom($info['email'], $info['name']);
		}
		$mailer->mail->addAddress($data['email'], $data['name']);
		$mailer->mail->addBCC($info['email'], $info['name']);
		$mailer->mail->isHTML(true);
		$mailer->mail->Subject = $template['subject'];
		$mailer->mail->Body = html_entity_decode($message);
		$mailer->mail->AltBody = 'Hello Dear, <br />
		Your support ticket. '.$data['subject'].' has been submitted. We try to reply to all tickets as soon as possible, usually within 24 hours.<br />
		Manage your ticket - '.URL_CLIENTS.DIR_ROUTE.'tickets .<br />
		Thank you,<br />
		Administrator';
		$mailer->sendMail();
	}

	private function ticketUpdateMail($data)
	{
		$info = $this->ticketModel->getInfo();
		$template = $this->ticketModel->getTemplate($data['template']);
		$ticket = $this->ticketModel->getTicket($data['id']);
		$message = $template['message'];
		$ticketurl = '<a href="'.URL_CLIENTS.DIR_ROUTE.'tickets'.'">Tickets</a>';
		$message = str_replace('{SUBJECT}', $ticket['subject'], $message);
		$message = str_replace('{NAME}', $ticket['name'], $message);
		$message = str_replace('{ID}', $ticket['id'], $message);
		$message = str_replace('{EMAIL}', $ticket['email'], $message);
		$message = str_replace('{MESSAGE}', $data['descr'], $message);
		$message = str_replace('{TICKETURL}', $ticketurl, $message);

		$mailer = new Mailer();
		$useornot = $mailer->getData();
		if (!$useornot) {
			$mailer->mail->setFrom($info['email'], $info['name']);
		}
		$mailer->mail->addAddress($ticket['email'], $ticket['name']);
		$mailer->mail->addBCC($info['email'], $info['name']);
		$mailer->mail->isHTML(true);
		$mailer->mail->Subject = $template['subject'];
		$mailer->mail->Body = html_entity_decode($message);
		$mailer->mail->AltBody = 'Hello Dear, <br />
		Staff just reply of your ticket. '.$ticket['subject'].'<br />
		Manage your ticket - '.URL_CLIENTS.DIR_ROUTE.'tickets .<br />
		Thank you,<br />
		Administrator';
		$mailer->sendMail();
	}

	private function ticketDelete($data)
	{
		$info = $this->ticketModel->getInfo();
		$template = $this->ticketModel->getTemplate($data['template']);
		$ticket = $this->ticketModel->getTicket($data['id']);
		$message = $template['message'];
		$ticketurl = '<a href="'.URL_CLIENTS.DIR_ROUTE.'tickets'.'">Tickets</a>';
		$message = str_replace('{SUBJECT}', $ticket['subject'], $message);
		$message = str_replace('{ID}', $ticket['id'], $message);
		$message = str_replace('{TICKETURL}', $ticketurl, $message);

		$mailer = new Mailer();
		$mailer->mail->setFrom($info['email'], $info['name']);
		$mailer->mail->addAddress($info['email'], $info['name']);
		$mailer->mail->isHTML(true);
		$mailer->mail->Subject = $template['subject'];
		$mailer->mail->Body = html_entity_decode($message);
		$mailer->mail->AltBody = 'Ticket Deleted <br />
		Ticket Subject : '.$ticket['subject'].'<br />
		Ticket ID: '.$data['id'].' is Deleted.<br />
		Thank you,<br />
		Administrator';
		$mailer->sendMail();
	}
}