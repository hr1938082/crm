<?php

/**
 * ContactController
 */
class ContactController extends Controller
{
	private $contactModel;
	function __construct()
	{
		parent::__construct();
		$this->commons = new CommonsController();
		/*Intilize User model*/
		$this->contactModel = new Contact();
	}
	/**
	 * Contact index method
	 * This method will be called on Contact list view
	 **/
	public function index()
	{
		if (!$this->commons->hasPermission('contacts')) {
			Not_foundController::show('403');
			exit();
		}

		/*Get User name and role*/
		$data = $this->commons->getUser();
		/**
		 * Get all User data from DB using User model 
		 **/
		if ($id = $this->commons->checkUser()) {
			$data['admin'] = false;
			$data['result'] = $this->contactModel->getContacts($id);
		} else {
			$data['admin'] = true;
			$data['result'] = $this->contactModel->getContacts();
		}

		/*Load Language File*/
		require DIR_BUILDER . 'language/' . $data['info']['language'] . '/common.php';
		$data['lang']['common'] = $lang;
		require DIR_BUILDER . 'language/' . $data['info']['language'] . '/contact.php';
		$data['lang']['contact'] = $contact;

		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}
		/* Set page title */
		$data['page_title'] = $data['lang']['common']['text_contacts'];

		/*Render User list view*/
		$this->view->render('contact/contact_list.tpl', $data);
	}
	/**
	 * Contact View method
	 * This method will be called on Contact View view
	 **/
	public function indexView()
	{
		if (!$this->commons->hasPermission('contact/view')) {
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

		if ($user_id = $this->commons->checkUser()) {
			$data['admin'] = false;
			$data['result'] = $this->contactModel->getContact($id, $user_id);
		} else {
			$data['admin'] = true;
			$data['result'] = $this->contactModel->getContact($id);
		}

		if (empty($data['result'])) {
			$this->url->redirect('contacts');
		}

		$data['client'] = $this->contactModel->getClient($data['result']['email']);
		$data['invoices'] = $this->contactModel->getInvoices($id);
		$data['quotes'] = $this->contactModel->getQuotes($id);
		if (!empty($data['client'])) {
			$data['clientactivity'] = $this->contactModel->getClientActivity($id);
		}

		$data['result']['marketing'] = json_decode($data['result']['marketing'], true);
		$data['result']['address'] = json_decode($data['result']['address'], true);
		$data['result']['persons'] = json_decode($data['result']['persons'], true);

		/*Load Language File*/
		require DIR_BUILDER . 'language/' . $data['info']['language'] . '/common.php';
		$data['lang']['common'] = $lang;
		require DIR_BUILDER . 'language/' . $data['info']['language'] . '/contact.php';
		$data['lang']['contact'] = $contact;

		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}
		/* Set page title */
		$data['page_title'] = $data['lang']['contact']['text_view_contact'];
		$data['action'] = URL . DIR_ROUTE . 'contact/action';
		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);

		/*Render User list view*/
		$this->view->render('contact/contact_view.tpl', $data);
	}
	/**
	 * Contact index ADD method
	 * This method will be called on ADD page
	 **/
	public function indexAdd()
	{
		if (!$this->commons->hasPermission('contact/add')) {
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
			$data['staff'] = $this->contactModel->getStaff();
		}

		/*Load Language File*/
		require DIR_BUILDER . 'language/' . $data['info']['language'] . '/common.php';
		$data['lang']['common'] = $lang;
		require DIR_BUILDER . 'language/' . $data['info']['language'] . '/contact.php';
		$data['lang']['contact'] = $contact;

		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}
		/* Set page title */
		$data['page_title'] = $data['lang']['common']['text_edit'] . ' ' . $data['lang']['common']['text_contact'];
		$data['action'] = URL . DIR_ROUTE . 'contact/action';
		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);

		/*Render User list view*/
		$this->view->render('contact/contact_form.tpl', $data);
	}
	/**
	 * Contact index Edit method
	 * This method will be called on Contact Edit view
	 **/
	public function indexEdit()
	{
		if (!$this->commons->hasPermission('contact/edit')) {
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
		if ($user_id = $this->commons->checkUser()) {
			$data['user']['user_id'] = $this->session->data['user_id'];
			$data['admin'] = false;
			$data['result'] = $this->contactModel->getContact($id, $user_id);
		} else {
			$data['admin'] = true;
			$data['result'] = $this->contactModel->getContact($id);
		}

		if (empty($data['result'])) {
			$this->url->redirect('contacts');
		}

		$data['client'] = $this->contactModel->getClient($data['result']['email']);
		$data['invoices'] = $this->contactModel->getInvoices($id);
		$data['quotes'] = $this->contactModel->getQuotes($id);
		$data['staff'] = $this->contactModel->getStaff();

		$data['result']['address'] = json_decode($data['result']['address'], true);
		$data['result']['persons'] = json_decode($data['result']['persons'], true);
		$data['result']['marketing'] = json_decode($data['result']['marketing'], true);

		/*Load Language File*/
		require DIR_BUILDER . 'language/' . $data['info']['language'] . '/common.php';
		$data['lang']['common'] = $lang;
		require DIR_BUILDER . 'language/' . $data['info']['language'] . '/contact.php';
		$data['lang']['contact'] = $contact;

		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}
		/* Set page title */
		$data['page_title'] = $data['lang']['common']['text_edit'] . ' ' . $data['lang']['common']['text_contact'];
		$data['action'] = URL . DIR_ROUTE . 'contact/action';
		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);

		/*Render User list view*/
		$this->view->render('contact/contact_form.tpl', $data);
	}
	/**
	 * Contact index Import method
	 * This method will be called on Contact Import
	 **/
	public function indexImport()
	{
		$this->commons->isAdmin();
		$filename = $_FILES["file"]["tmp_name"];
		$data = '';
		$row = 0;
		$expire = date('Y-m-d', strtotime('+1 years'));
		if ($_FILES["file"]["size"] > 0) {
			$file = fopen($filename, "r");
			while (($getData = fgetcsv($file, 10000, ",")) !== FALSE) {
				if ($row == 0 && $getData[0] !== 'Salutation' && $getData[1] !== 'First Name' && $getData[2] !== 'Last Name' && $getData[3] !== 'Company' && $getData[4] !== 'Email Address' && $getData[5] !== 'Phone Number' && $getData[6] !== 'Website' && $getData[7] !== 'Address Line 1' && $getData[8] !== 'Address Line 2' && $getData[9] !== 'City' && $getData[10] !== 'State' && $getData[11] !== 'Country' && $getData[12] !== 'Postal Code') {
					echo 0;
					exit();
				}
				if ($row > 0) {
					$temp = array('address1' => $getData[7], 'address2' => $getData[8], 'city' => $getData[9], 'state' => $getData[10], 'country' => $getData[11], 'pin' => $getData[12], 'phone1' => '', 'fax' => '');
					$data .= "('" . $getData[0] . "','" . $getData[1] . "','" . $getData[2] . "','" . $getData[3] . "','" . $getData[4] . "','" . $getData[5] . "','" . $getData[6] . "','" . json_encode($temp) . "','" . $getData[11] . "','" . $expire . "'),";
				}
				$row++;
			}
			fclose($file);
		}
		$data = rtrim($data, ',');
		$result = $this->contactModel->importContact($data);
		if ($result) {
			echo 1;
		} else {
			echo 0;
		}
	}

	public function indexSmapleDownload()
	{
		$this->commons->isAdmin();
		if (file_exists(DIR . 'public/uploads/contact_sample.csv')) {
			$filepath = "public/uploads/contact_sample.csv";
			echo "string";
			if (file_exists($filepath)) {
				header('Content-Description: File Transfer');
				header('Content-Type: application/octet-stream');
				header('Content-Disposition: attachment; filename="' . basename($filepath) . '"');
				header('Expires: 0');
				header('Cache-Control: must-revalidate');
				header('Pragma: public');
				header('Content-Length: ' . filesize($filepath));
				flush();
				readfile($filepath);
				echo "<script>window.close();</script>";
				exit;
			}
		} else {
			echo "<script>window.close();</script>";
			exit;
		}
	}
	/**
	 * Contact index method
	 * This method will be called on Contact ADD or Update view
	 **/
	public function indexAction()
	{
		if ((!$this->commons->hasPermission('contact/edit')) && (!$this->commons->hasPermission('contact/add'))) {
			Not_foundController::show('403');
			exit();
		}
		/**
		 * Check if from is submitted or not 
		 **/
		if (!isset($_POST['submit'])) {
			$this->url->redirect('contacts');
			exit();
		}
		/**
		 * Validate form data
		 * If some data is missing or data does not match pattern
		 * Return to info view 
		 **/
		if ($validate_field = $this->validateField()) {
			$this->session->data['message'] = array('alert' => 'error', 'value' => 'Please enter valid ' . implode(", ", $validate_field) . '!');
			$this->url->redirect('contacts');
		}

		if ($this->commons->validateToken($this->url->post('_token'))) {
			$this->session->data['message'] = array('alert' => 'warning', 'value' => 'Token does not match!');
			$this->url->redirect('contacts');
		}

		if (!empty($this->url->post('id'))) {
			$data = $this->url->post('contact');
			$data['client'] = $this->url->post('client');
			$data['country'] = $data['address']['country'];
			$data['address'] = json_encode($data['address']);
			$data['person'] = json_encode($data['person']);
			$data['id'] = $this->url->post('id');
			$data['expire'] = date_format(date_create($data['expire']), 'Y-m-d');

			$data['marketing']['email'] = isset($data['marketing']['email']) ? $data['marketing']['email'] : false;
			$data['marketing']['phone'] = isset($data['marketing']['phone']) ? $data['marketing']['phone'] : false;
			$data['marketing']['sms'] = isset($data['marketing']['sms']) ? $data['marketing']['sms'] : false;
			$data['marketing']['social'] = isset($data['marketing']['social']) ? $data['marketing']['social'] : false;
			$data['marketing'] = json_encode($data['marketing']);

			$result = $this->contactModel->updateContact($data);
			$this->session->data['message'] = array('alert' => 'success', 'value' => 'Contact updated successfully.');
			$this->url->redirect('contact/edit&id=' . $this->url->post('id'));
		} else {
			$data = $this->url->post('contact');
			$data['country'] = $data['address']['country'];
			$data['address'] = json_encode($data['address']);
			$data['person'] = json_encode($data['person']);
			$data['expire'] = date_format(date_create($data['expire']), 'Y-m-d');

			$data['marketing']['email'] = isset($data['marketing']['email']) ? $data['marketing']['email'] : false;
			$data['marketing']['phone'] = isset($data['marketing']['phone']) ? $data['marketing']['phone'] : false;
			$data['marketing']['sms'] = isset($data['marketing']['sms']) ? $data['marketing']['sms'] : false;
			$data['marketing']['social'] = isset($data['marketing']['social']) ? $data['marketing']['social'] : false;
			$data['marketing'] = json_encode($data['marketing']);

			$result = $this->contactModel->createContact($data);
			$this->session->data['message'] = array('alert' => 'success', 'value' => 'Contact created successfully.');
			$this->url->redirect('contact/edit&id=' . $result);
		}
	}
	/**
	 * Contact index Delete method
	 * This method will be called on Contact Delete view
	 **/
	public function indexDelete()
	{
		if (!$this->commons->hasPermission('contact/delete')) {
			Not_foundController::show('403');
			exit();
		}
		$delete = $this->url->post('delete');
		if ($delete) {
			foreach ($delete as $id) {
				$result = $this->contactModel->deleteContact($id);
			}
		} else {
			$result = $this->contactModel->deleteContact($this->url->post('id'));
		}
		$this->session->data['message'] = array('alert' => 'success', 'value' => 'Contact deleted successfully.');
		$this->url->redirect('contacts');
	}
	/**
	 * Contact index Mail method
	 * This method will be called on Contact Mail
	 **/
	public function indexMail()
	{
		if (!$this->commons->hasPermission('contact/view')) {
			Not_foundController::show('403');
			exit();
		}
		$data = $this->url->post('mail');

		if ($validate_field = $this->vaildateMailField($data)) {
			$this->session->data['message'] = array('alert' => 'error', 'value' => 'Please enter valid ' . implode(", ", $validate_field) . '!');
			$this->url->redirect('contact/view&id=' . $data['contact']);
		}

		if ($this->commons->validateToken($this->url->post('_token'))) {
			$this->url->redirect('contact/view&id=' . $data['contact']);
		}

		$info = $this->contactModel->getOrganization();

		$mailer = new Mailer();
		$useornot = $mailer->getData();
		if (!$useornot) {
			$mailer->mail->setFrom($info['email'], $info['name']);
		}

		$mailer->mail->addAddress($data['to'], $data['name']);
		if (!empty($data['bcc'])) {
			$mailer->mail->addBCC($data['bcc'], $data['bcc']);
		}

		$mailer->mail->isHTML(true);
		$mailer->mail->Subject = $data['subject'];
		$mailer->mail->Body = html_entity_decode($data['message']);

		$mailer->sendMail();
		$data['type'] = "contact";
		$data['type_id'] = $data['contact'];
		$data['user_id'] = $this->session->data['user_id'];

		$this->contactModel->emailLog($data);
		$this->session->data['message'] = array('alert' => 'success', 'value' => 'Email Sent successfully.');
		$this->url->redirect('contact/view&id=' . $data['contact']);
	}
	/**
	 * Validate Field Method
	 * This method will be called on to validate invoice field
	 **/
	private function vaildateMailField($data)
	{
		$error = [];
		$error_flag = false;

		if ($this->commons->validateText($data['to'])) {
			$error_flag = true;
			$error['to'] = 'Email!';
		}

		if ($this->commons->validateText($data['subject'])) {
			$error_flag = true;
			$error['subject'] = 'Subject!';
		}

		if ($this->commons->validateText($data['message'])) {
			$error_flag = true;
			$error['message'] = 'Message!';
		}

		if ($error_flag) {
			return $error;
		} else {
			return false;
		}
	}
	/**
	 * Contact validate field method
	 * This method will be called for validate input field
	 **/
	public function validateField()
	{
		$error = [];
		$error_flag = false;

		if ($this->commons->validateText($this->url->post('contact')['company'])) {
			$error_flag = true;
			$error['author'] = 'Item Rate!';
		}

		if ($error_flag) {
			return $error;
		} else {
			return false;
		}
	}
	/**
	 * Contact index Client method
	 * This method will be called on Client list view
	 **/
	public function indexClients()
	{
		if (!$this->commons->hasPermission('clients')) {
			Not_foundController::show('403');
			exit();
		}

		/*Get User name and role*/
		$data = $this->commons->getUser();
		/**
		 * Get all User data from DB using User model 
		 **/
		$data['result'] = $this->contactModel->getClients();

		/*Load Language File*/
		require DIR_BUILDER . 'language/' . $data['info']['language'] . '/common.php';
		$data['lang']['common'] = $lang;
		require DIR_BUILDER . 'language/' . $data['info']['language'] . '/contact.php';
		$data['lang']['contact'] = $contact;

		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}
		/* Set page title */
		$data['page_title'] = $data['lang']['common']['text_clients'];

		/*Render User list view*/
		$this->view->render('contact/client_list.tpl', $data);
	}
	/**
	 * Contact index CLient Edit method
	 * This method will be called on Client Edit view
	 **/
	public function indexClientEdit()
	{
		if (!$this->commons->hasPermission('client/edit')) {
			Not_foundController::show('403');
			exit();
		}
		/**
		 * Check if id exist in url if not exist then redirect to Client list view 
		 **/
		$id = (int)$this->url->get('id');
		if (empty($id) || !is_int($id)) {
			$this->url->redirect('clients');
		}
		/*Get User name and role*/
		$data = $this->commons->getUser();
		/**
		 * Get all Client data from DB using Client model 
		 **/
		$data['result'] = $this->contactModel->getClientByID($id);

		if (empty($data['result'])) {
			$this->url->redirect('clients');
		}

		/*Load Language File*/
		require DIR_BUILDER . 'language/' . $data['info']['language'] . '/common.php';
		$data['lang']['common'] = $lang;
		require DIR_BUILDER . 'language/' . $data['info']['language'] . '/contact.php';
		$data['lang']['contact'] = $contact;

		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}

		/* Set page title */
		$data['page_title'] = $data['lang']['common']['text_edit'] . ' ' . $data['lang']['common']['text_client'];
		$data['action'] = URL . DIR_ROUTE . 'client/action';
		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);

		/*Render User list view*/
		$this->view->render('contact/client_form.tpl', $data);
	}
	/**
	 * Contact index Client Action method
	 * This method will be called on Client Action view
	 **/
	public function indexClientAction()
	{
		if ((!$this->commons->hasPermission('client/edit'))) {
			Not_foundController::show('403');
			exit();
		}

		if ($this->commons->validateToken($this->url->post('_token'))) {
			$this->session->data['message'] = array('alert' => 'warning', 'value' => 'Token does not match!');
			$this->url->redirect('contacts');
		}

		$data = $this->url->post('client');
		$result = $this->contactModel->updateClient($data);
		$this->session->data['message'] = array('alert' => 'success', 'value' => 'Client updated successfully.');
		$this->url->redirect('client/edit&id=' . $data['id']);
	}
	/**
	 * Contact index Client Delete method
	 * This method will be called on Client Delete view
	 **/
	public function indexClientDelete()
	{
		if (!$this->commons->hasPermission('client/delete')) {
			Not_foundController::show('403');
			exit();
		}
		$result = $this->contactModel->deleteClient($this->url->post('id'));
		$this->session->data['message'] = array('alert' => 'success', 'value' => 'Client deleted successfully.');
		$this->url->redirect('clients');
	}
}
