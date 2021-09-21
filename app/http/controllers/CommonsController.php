<?php
/**
* Commons Controller
*/
class CommonsController extends Controller
{
/**
	* Get USer method
	* This method will be called to get USer Data
	**/
	public function getUser()
	{
		$commons = new Commons();
		$id= $this->session->data['user_id'];
		$data['user'] = $commons->getUserData($id);
		$data['info'] = $commons->getOrganization();
		$data['info']['theme'] = json_decode($data['info']['theme'], true);
		if (empty($data['info']['language'])) {
			$data['info']['language'] = 'en-US';
		}
		return $data;
	}

	public function getInfo()
	{
		$commons = new Commons();
		return $commons->getOrganization();
	}
	/**
	* Has permission method
	* This method will be called to check permmission
	**/
	public function hasPermission($uri)
	{
		if ($this->session->data['role'] == '1') {
			return true;
		} else {
			$commons = new Commons();
			$result = $commons->getRoleString($this->session->data['role']);
			$result = json_decode($result, true);
			if (in_array($uri, $result)) { return true; }
			else { return false; }
		}
	}

	public function isAdmin()
	{
		if ($this->session->data['role'] != "1") {
			Not_foundController::show('403');
			exit();
		}
	}

	public function checkUser()
	{
		if ($this->session->data['role'] == 1) {
			return false;
		} else {
			return $this->session->data['user_id'];
		}
	}

	public function indexCloseTab()
	{
		echo "<script>window.close();</script>";
		exit();
	}

	public function indexErrorLog()
	{
		$data = $this->getUser();

		/*Load Language File*/
		require DIR_BUILDER.'language/'.$data['info']['language'].'/common.php';
		$data['lang']['common'] = $lang;

		/*Render Setting view*/
		$this->view->render('not_found/errorlog.tpl', $data);
	}

	public function indexPermission()
	{
		$data = $this->getUser();
		/*Load Language File*/
		require DIR_BUILDER.'language/'.$data['info']['language'].'/common.php';
		$data['lang']['common'] = $lang;
		/*Render Setting view*/
		$this->view->render('setting/permission.tpl', $data);
	}
	/**
	* Validate Email Method
	**/
	public function validateEmail($email)
	{
		if ((strlen($email) > 96) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
			return true;
		}
		else {
			return false;
		}
	}
	/**
	* Validate Text or String Method
	**/
	public function validateText($text)
	{
		if ((strlen($text) < 2) || !is_string($text)) {
			return true;
		}
		else {
			return false;
		}
	}
	/**
	* Validate URL Method
	**/
	public function validateUrl($url)
	{
		if (!filter_var($url, FILTER_VALIDATE_URL) === false) {
			return false;
		} else {
			return true;
		}
	}
	/**
	* Validate Numeric Mthod
	**/
	public function validateNumeric($numeric)
	{
		if (is_numeric($numeric)) {
			return false;
		} else {
			return true;
		}
	}
	/**
	* Validate Number Method
	**/
	public function validateNumber($number)
	{
		if (!filter_var($number, FILTER_VALIDATE_INT) === false) {
			return false;
		}
		else {
			return true;
		}
	}
	/**
	* Validate Phone Number
	**/
	public function validatePhoneNumber($phone_number)
	{
		if ((strlen($phone_number) < 4) || (strlen($phone_number) > 32)) {
			return true;
		}
		else if ($this->validateNumeric($phone_number)) {
			return true;
		}
		else {
			return false;
		}
	}
	/**
	* Validate Date Method
	**/
	public function validateDate($date)
	{
		if ($this->validateDateFormat($date)) {
			return false;
		}
		else {
			return true;
		}
	}
	/**
	* Validate Date format Method
	**/
	protected function validateDateFormat($date, $format = 'Y-m-d')
	{	
		$d = DateTime::createFromFormat($format, $date);
		return $d && $d->format($format) == $date;
	}
	/**
	* Validate Security Token Method
	**/
	public function validateToken($token)
	{
		$token_check = hash('sha512', TOKEN . TOKEN_SALT);
		if (hash_equals($token_check, $token) === false ){
			$this->session->data['message'] = array('alert' => 'danger', 'value' => 'Invalid token. Please try again.');
			return true;
		}
	}
}