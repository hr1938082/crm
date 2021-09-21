<?php

/**
* Login Controller
*/
class LoginController extends Controller
{
	private $common;
	function __construct()
	{
		parent::__construct();
		/**
		* Check if user is logged in or not
		* If logged in then get user basic info from DB
		**/
		$this->commons = new CommonsController();
		$this->common = new Common();
	}
	/**
	* Login index method
	* This method will be called on Login view
	**/
	public function api_chk(){
	    
	    
	    var_dump('ss');
	    die();
	}
	
	
	public function index()
	{
		if ($this->common->isLoggedIn()) {
			$this->url->redirect('dashboard');
		}
		$data['error'] = '';
		if (isset($this->session->data['error'])) {
			$data['error'] = $this->session->data['error'];
			unset($this->session->data['error']);
		}

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];
			unset($this->session->data['success']);
		}

		if (isset($_SERVER['HTTP_REFERER']) && !empty($_SERVER['HTTP_REFERER'])) {
			$this->session->data['refferal'] = $_SERVER['HTTP_REFERER'];
		}

		$data['info'] = $this->commons->getInfo();

		/*Load Language File*/
		require DIR_BUILDER.'language/'.$data['info']['language'].'/common.php';
		$data['lang']['common'] = $lang;
		require DIR_BUILDER.'language/'.$data['info']['language'].'/login.php';
		$data['lang']['login'] = $login;

		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);
		$data['action'] = URL.DIR_ROUTE.'login';
		$this->view->render('auth/login.tpl', $data);
	}
	/**
	* Login method
	* This method will be called on Login submit
	**/
	public function login()
	{	
		if ($this->common->isLoggedIn()) {
			$this->url->redirect('dashboard');
		}
		if ($this->commons->validateToken($this->url->post('_token'))){
			$this->url->redirect('login');
		}

		$username = $this->url->post('username');
		$password = $this->url->post('password');

		if (!$this->validate($username, $password)) {
			$this->session->data['error'] = 'Warning: Please enter valid data in input box.';
			$this->url->redirect('login');
		}

		unset($this->session->data['user_id']);
		unset($this->session->data['login_token']);
		unset($this->session->data['role']);

		/*Intiate login Model*/
		$this->loginModel = new Login();
		/** 
		* If the user exists
		* Check his account and login attempts
		* Get user data 
        **/
		if ($user = $this->loginModel->checkUser($username)) {
			/** 
			* User exists now We check if
			* The account is locked From too many login attempts 
            **/
			if (!$this->checkLoginAttempts($user['email'])) {
				$this->session->data['error'] = 'Warning: Your account has exceeded allowed number of login attempts. Please try again in 1 hour.';
				
				$this->url->redirect('login');
			}
			else if ($user['status'] === 1) {
	            /** 
	            * Check if the password in the database matches the password user submitted.
	            * We are using the password_verify function to avoid timing attacks.
	            **/
	            if (password_verify( $password, $user['password'])) {
	            	$this->loginModel->deleteAttempt($user['email']);
	            	/** 
	            	* Start session for user create session varible 
		            * Create session login string for authentication
		            **/
	            	$this->session->data['user_id'] = preg_replace("/[^0-9]+/", "", $user['user_id']); 
	            	$this->session->data['role'] = preg_replace("/[^0-9]+/", "", $user['user_role']);
	            	$this->session->data['login_token'] = hash('sha512', AUTH_KEY . LOGGED_IN_SALT);
	            	$this->url->Redirect('dashboard');
	            } else {
	            	/** 
	            	* Add login attemt to Db
		            * Redirect back to login page and set error for user
		            **/
	            	$this->loginModel->addAttempt($user['email']);
	            	$this->session->data['error'] = 'Warning: No match for Username and/or Password.';
	            	$this->url->Redirect('login');
	            }
	        }
	        else {
	        	/** 
	        	* If account is disabled by admin 
		        * Then Show error to user
		        **/
	        	$this->session->data['error'] = 'Warning: Your account has disabled for more info contact us.';
	        	$this->url->redirect('login');
	        }
	    }
	    else {
	    	/** 
	        * If email address not found in DB 
		    * Show error to user for creating account
		    **/
	    	$this->session->data['error'] = 'Warning: No match for Username and/or Password.';
	    	$this->url->redirect('login');
	    }
	}
	/**
	* Forgot index Forgot method
	* This method will be called on forgot View
	**/
	public function indexForgot()
	{
		$data['error'] = '';
		if (isset($this->session->data['error'])) {
			$data['error'] = $this->session->data['error'];
			unset($this->session->data['error']);
		}

		if (isset($_SERVER['HTTP_REFERER']) && !empty($_SERVER['HTTP_REFERER'])) {
			$this->session->data['refferal'] = $_SERVER['HTTP_REFERER'];
		}
		
		$data['info'] = $this->commons->getInfo();

		/*Load Language File*/
		require DIR_BUILDER.'language/'.$data['info']['language'].'/common.php';
		$data['lang']['common'] = $lang;
		require DIR_BUILDER.'language/'.$data['info']['language'].'/login.php';
		$data['lang']['login'] = $login;

		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);
		$data['action'] = URL.DIR_ROUTE.'forgot';
		$this->view->render('auth/forgot.tpl', $data);
	}
	/**
	* forgot method
	* This method will be called on forgot submit
	**/
	public function forgot()
	{
		/**
		* Intilize Url class for post and get request
		**/
		$email = $this->url->post('mail');
		/** 
		* Check submit is POST request 
		* Validate input field
        **/
		if (!isset($_POST['forgot']) || !$this->validateForgot($email)) {
			$this->session->data['error'] = 'Warning: Please enter valid data in input box.';
			$this->url->redirect('forgot');
		}

		$token = $this->url->post('_token');
		$token_check = hash('sha512', TOKEN . TOKEN_SALT);
		if (hash_equals($token_check, $token) === false ) {
			$this->session->data['error'] = 'Warning: Invalid token. Please try again.';
			$this->url->redirect('forgot');
		}

		/** 
		* If the user exists
		* Check his account and login attempts
		* Get user data 
        **/
		$this->loginModel = new Login();
		if ($user = $this->loginModel->checkUserEmail($email)) {
			/** 
			* Check Login attempt
			* The account is locked From too many login attempts 
            **/
			if (!$this->checkLoginAttempts($email)) {
				$this->session->data['error'] = 'Warning: Your account has exceeded allowed number of login attempts. Please try again in 1 hour.';
				$this->url->redirect('forgot');
			} elseif ( $user['status'] != "1" ) {
				$data['hash'] = md5(uniqid(mt_rand(), true));
				$data['email'] = $email;
				$data['name'] = $user['name'];
				$this->loginModel->editHash($data);
				$this->forgotMail($data);
				$this->session->data['success'] = 'Success: Reset instruction sent to your E-mail address.';
				$this->url->redirect('login');
			} else {
	        	/** 
	        	* If account is disabled by admin 
		        * Then Show error to user
		        **/
	        	$this->session->data['success'] = 'Success: Your account has disabled by admin, For more info contact us.';
	        	$this->url->redirect('login');
	        }

			/** 
			* User exists now We check if
			* Send Mail to user for reset password
            **/

		} else {
			$this->session->data['error'] = 'Warning: Account does not exists.';
			$this->url->redirect('forgot');
		}
	}

	private function forgotMail($data)
	{
		$info = $this->loginModel->getOrganization();

		$template = $this->loginModel->getTemplate('forgotpassword');
		$reset_link = '<a href="'.URL.DIR_ROUTE.'reset&id='.$data['email'].'&temp='.$data['hash'].'">Click Here</a>';
		$message = $template['message'];
		$message = str_replace('{name}', $data['name'], $message);
		$message = str_replace('{email}', $data['email'], $message);
		$message = str_replace('{reset_link}', $reset_link, $message);
		$message = str_replace('{business_name}', $info['name'], $message);
		
		$mailer = new Mailer();
		$useornot = $mailer->getData();
		if (!$useornot) {
			$mailer->mail->setFrom($info['email'], $info['name']);
		}
		$mailer->mail->addAddress($data['email'], $data['name']);
		$mailer->mail->isHTML(true);
		$mailer->mail->Subject = $template['subject'];
		$mailer->mail->Body = html_entity_decode($message);
		$mailer->mail->AltBody = 'Hello Dear,
		This is to confirm that we have received a Forgot Password request for your Account Username - '.$data['email'].'<br /> Click Here : '.$reset_link.'';
		$mailer->sendMail();
		
	}

	/**
	* Logout
	**/
	public function logout()
	{
		$this->session->destroy();
		$this->url->redirect('login');
	}

	/**
	* Validate login credentials on server side
	* Validation is also done on client side (Using html5 and javascripts)
	**/
	protected function validate($email, $password) 
	{
		/** 
		* Check if email and password contains valid phrases
		**/
		if (strlen($email) < 4 ) {
			/** 
			* If email is not valid
			* Return false
			**/
			return false;
		}
		elseif (strlen($password) < 6) {
			/** 
			* If password is not valid or minimum 6 character
			* Return false
			**/
			return false;
		}
		else {
			return true;
		}
	}

	/**
	* Validate login credentials on server side
	* Validation is also done on client side (Using html5 and javascripts)
	**/
	protected function validateForgot($email) 
	{
		/** 
		* Check if email and password contains valid phrases
		**/
		if ($this->commons->validateEmail($email)) {
			$error_flag = true;
			$error['email'] = 'Email Address';
		}
		else {
			return true;
		}
	}

	/** 
	* Check login attempts of user for brute force attacks 
	**/
	protected function checkLoginAttempts($email)
	{
		/**
		* Get attempts from DB and check with predefined field
		* All login attempts are counted from the past 1 hours. 
		**/
		$login_attempts = $this->loginModel->checkAttempts($email);
		if ($login_attempts && ($login_attempts['count'] >= 4) && strtotime('-1 hour') < strtotime($login_attempts['date_modified'])) {
			return false;
		}
		else {
			return true;
		}
	}
	/**
	* Reset Password method
	* This method will be called on Reset Password View
	**/
	public function resetPassword()
	{

		if ($this->common->isLoggedIn()) {
			$this->url->redirect('dashboard');
		}

		$data['error'] = '';
		if (isset($this->session->data['error'])) {
			$data['error'] = $this->session->data['error'];
			unset($this->session->data['error']);
		}

		$data['success'] = '';
		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];
			unset($this->session->data['success']);
		}
		$data['mail'] = $this->url->get('id');
		$data['hash'] = $this->url->get('temp');
		
		if (empty($data['mail']) && empty($data['hash']) ) {
			$this->url->redirect('login');
		}
		$this->loginModel = new Login();
		if (!$this->loginModel->checkEmailHash($data)) {
			$this->url->redirect('login');
		}
		
		$data['info'] = $this->commons->getInfo();

		/*Load Language File*/
		require DIR_BUILDER.'language/'.$data['info']['language'].'/common.php';
		$data['lang']['common'] = $lang;
		require DIR_BUILDER.'language/'.$data['info']['language'].'/login.php';
		$data['lang']['login'] = $login;
		
		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);
		$data['action'] = URL.DIR_ROUTE.'reset';
		$this->view->render('auth/reset_password.tpl', $data);
	}	
	/**
	* Reset Password Action method
	* This method will be called on Reset Password Submit
	**/
	public function resetPasswordAction()
	{

		$data = $this->url->post;
		if (!isset($_POST['reset']) || !$this->validateReset($data)) {
			$this->session->data['error'] = 'Warning: Please enter valid data in input box.';
			$this->url->redirect('login');
		}

		$token = $this->url->post('_token');
		$token_check = hash('sha512', TOKEN . TOKEN_SALT);
		if (hash_equals($token_check, $token) === false ) {
			$this->session->data['error'] = 'Warning: Invalid token. Please try again.';
			$this->url->redirect('login');
		}
		$this->loginModel = new Login();
		$check = $this->loginModel->checkEmailHash($data);
		if (empty($check)) {
			$this->url->redirect('login');
		} else {
			$result = $this->loginModel->updatePassword($data);
			$this->session->data['success'] = 'Success: Your Password Changed Succesfully.';
			$this->url->redirect('login');
		}

		
	}
	/** 
	* Validate input field on server side
	* Check if email and password contains valid phrases
	**/
	protected function validateReset($data)
	{
		/** 
		* Validate input field on server side
		* Check if email and password contains valid phrases
		**/
		if ((strlen(trim($data['hash'])) < 10) || (strlen(trim($data['hash'])) > 255)) {
			/** 
			* If First name is not valid ( min 2 character or max 48 ) 
			* Return false
			**/
			return false;
		}  elseif ((strlen($data['mail']) > 96) || !filter_var($data['mail'], FILTER_VALIDATE_EMAIL)) {
			/** 
			* If email is not valid
			* Return false
			**/
			return false;
		} elseif (strlen($data['password']) < 6) {
			/** 
			* If Password is not valid ( min 6 character ) 
			* Return false
			**/
			return false;
		} elseif ($data['confirmpassword'] != $data['password']) {
			/** 
			* If Password does not match with confirmpassword 
			* Return false
			**/
			return false;
		} else {
			/** 
			* Everything looks good 
			* Return True
			**/
			return true;
		}
	}
}