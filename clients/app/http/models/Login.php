<?php

/**
* Login Model
*/
class Login extends Model
{
	public function checkUser($email)
	{
		$query = $this->model->query( "SELECT c.id, c.name, c.email, c.password, c.status, ct.id AS `customer` FROM `" . DB_PREFIX . "clients` AS c LEFT JOIN `" . DB_PREFIX . "contacts` AS ct ON c.email = ct.email WHERE c.email = ? LIMIT 1", array($this->model->escape($email)));
		
		if ($query->num_rows) {
			return $query->row;
		} else {
			return false;
		}
	}

	public function getTemplate($name)
	{
		$query = $this->model->query("SELECT * FROM `" . DB_PREFIX . "template` WHERE `template` = ? LIMIT 1", array($name));
		return $query->row;
	}

	public function checkUserId($id)
	{
		$query = $this->model->query( "SELECT `id`, `name`, `email`, `status` FROM `" . DB_PREFIX . "clients` WHERE `id` = ? AND `status` = ? LIMIT 1", array($this->model->escape($id), 1));
		if ($query->num_rows > 0) {
			return $query->row;
		} else {
			return false;
		}
	}

	public function checkAttempts($email)
	{
		$query = $this->model->query("SELECT * FROM `" . DB_PREFIX . "login_attempts` WHERE `email` = ?", array($this->model->escape($email)));
		if ($query->num_rows) {
			return $query->row;
		} else {
			return false;
		}
	}

	public function addAttempt($email)
	{
		$query = $this->model->query("SELECT * FROM `" . DB_PREFIX . "login_attempts` WHERE `email` = ? ", array($this->model->escape($email)));
		if ($query->num_rows > 0) {
			$this->model->query("UPDATE `" . DB_PREFIX . "login_attempts` SET `count` = ?, `date_modified` = ? WHERE `email` = ?", array( $query->row['count'] + 1 , date('Y-m-d H:i:s'), $email));
		}
		else {
			$this->model->query("INSERT INTO `" . DB_PREFIX . "login_attempts` SET `email` = ?, `count` = ?, `date_added` = ?, `date_modified` = ?", array($email, 1, date('Y-m-d H:i:s'), date('Y-m-d H:i:s')));
		}
	}

	public function deleteAttempt($email)
	{
		$this->model->query("DELETE FROM `" . DB_PREFIX . "login_attempts` WHERE `email` = ?", array($this->model->escape($email)));
	}

	public function checkClient($email)
	{
		$query = $this->model->query( "SELECT `email` FROM `" . DB_PREFIX . "clients` WHERE `email` = ?", array($this->model->escape($email)));
		if ($query->num_rows) {
			return $query->row;
		} else {
			return false;
		}
	}

	public function createAccount($data) 
	{
		$passwordhash = password_hash($data['password'], PASSWORD_DEFAULT);
		$this->model->query("INSERT INTO `" . DB_PREFIX . "clients` (`name`, `email`, `password`, `hash`, `status`) VALUES (?, ?, ?, ?, ?) ",  array($this->model->escape($data['name']), $this->model->escape($data['mail']), $this->model->escape($passwordhash), $this->model->escape($data['temp_hash']), 1));

		$query = $this->model->query( "SELECT `id` FROM `" . DB_PREFIX . "contacts` WHERE `email` = ? LIMIT 1", array($this->model->escape($data['mail'])));
		
		if ($query->num_rows < 1) {
			$this->model->query("INSERT INTO `" . DB_PREFIX . "contacts` (`firstname`, `lastname`, `company`, `email`, `phone`, `expire`) VALUES (?, ?, ?, ?, ?, ?) ", array($data['fname'], $data['lname'], $data['fname'], $this->model->escape($data['mail']), $this->model->escape($data['mobile']), $data['expire']));
			return $this->model->last_id();
		} else {
			return $query->row['id'];
		}
	}

	public function clientActivity($data)
	{
		$this->model->query("INSERT INTO `" . DB_PREFIX . "client_activity` (`name`, `type_id`, `ip`) VALUES (?, ?, ?) ", array($this->model->escape($data['name']), $data['type_id'], $data['ip']));
	}

	public function editHash($data)
	{
		$query = $this->model->query("UPDATE `" . DB_PREFIX . "clients` SET `hash` = ? WHERE `email` = ? ", array($this->model->escape($data['hash']), $this->model->escape($data['email'])));
	}

	public function checkEmailHash($data)
	{
		$query = $this->model->query( "SELECT `email` FROM `" . DB_PREFIX . "clients` WHERE `email` = ? AND `hash` = ?", array($this->model->escape($data['mail']), $data['hash']));
		if ($query->num_rows) {
			return $query->row;
		} else {
			return false;
		}
	}

	public function updatePassword($data)
	{
		$data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
		$this->model->query("UPDATE `" . DB_PREFIX . "clients` SET `password` = ?, `hash` = ? WHERE `email` = ? AND `hash` = ? ", array($data['password'], '', $data['mail'], $data['hash']));
	}
}