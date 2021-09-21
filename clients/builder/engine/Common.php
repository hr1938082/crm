<?php

/**
* Common Controller
*/
class Common extends Controller
{
	public function isLoggedIn()
	{
		/**
		* Check if all session variables are set
		* User_id and Login_auth string 
		**/
		if (isset($this->session->data['user_id']) && isset($this->session->data['login_token'])) {
			$login_auth = $this->session->data['login_token'];
			/**
			* Make hash string to check
			* with login auth string
			**/
			$login_check = hash('sha512', AUTH_KEY . LOGGED_IN_SALT);

			if (hash_equals($login_check, $login_auth)) {

				/**
				* If strings are equal
				* Return True
				**/
				$this->loginModel = new Login();
				$user = $this->loginModel->checkUserId($this->session->data['user_id']);
					
				if (!empty($user['id'])) {
					return true;
				} else {
					unset($this->session->data['user_id']);
					unset($this->session->data['login_token']);
					return false;
				}
			} else {
				/**
				* If strings are not equal
				* Return False
				**/
				return false;
			}
		} else {
			/**
			* If session variables are not set
			* Return false
			**/
			return false;
		}
	}
}