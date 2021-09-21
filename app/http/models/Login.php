<?php

/**
* Login Model
*/
class Login extends Model
{
	public function checkUser($username)
	{
		$query = $this->model->query( "SELECT `user_id`, `user_role`, `firstname`, `lastname`, `email`, `mobile`, `password`, `status` FROM `" . DB_PREFIX . "users` WHERE `user_name` = ? LIMIT 1", array($this->model->escape($username)));
		if ($query->num_rows) {
			return $query->row;
		} else {
			return false;
		}
	}

	public function getOrganization()
	{
		$query = $this->model->query("SELECT * FROM `" . DB_PREFIX . "info` WHERE `id` = ?", array(1));
		if ($query->num_rows > 0) {
			return $query->row;
		} else {
			return '';
		}
	}

	public function checkUserEmail($data)
	{
		$query = $this->model->query( "SELECT `user_id`, CONCAT(`firstname`, ' ' ,`lastname`) AS name,  `email` `status` FROM `" . DB_PREFIX . "users` WHERE `email` = ? LIMIT 1", array($this->model->escape($data)));
		if ($query->num_rows) {
			return $query->row;
		} else {
			return false;
		}
	}

	public function checkUserId($id)
	{
		$query = $this->model->query( "SELECT `user_id`, `user_role`, `firstname`, `email`, `status` FROM `" . DB_PREFIX . "users` WHERE `user_id` = ? AND `status` = ? LIMIT 1", array($this->model->escape($id), 1));
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
			$results['count'] = $query->row['count'];
			$this->model->query("UPDATE `" . DB_PREFIX . "login_attempts` SET `count` = ?, `date_modified` = ? WHERE `email` = ?", array( $results['count'] + 1 , date('Y-m-d H:i:s'), $email));
		}
		else {
			$this->model->query("INSERT INTO `" . DB_PREFIX . "login_attempts` SET `email` = ?, `count` = ?, `date_added` = ?, `date_modified` = ?", array($email, 1, date('Y-m-d H:i:s'), date('Y-m-d H:i:s')));
		}
	}

	public function deleteAttempt($email)
	{
		$this->model->query("DELETE FROM `" . DB_PREFIX . "login_attempts` WHERE `email` = ?", array($this->model->escape($email)));
	}


	public function editHash($data)
	{
		$query = $this->model->query("UPDATE `" . DB_PREFIX . "users` SET `temp_hash` = ? WHERE `email` = ? ", array($this->model->escape($data['hash']), $this->model->escape($data['email'])));
	}

	public function checkEmailHash($data)
	{
		$query = $this->model->query( "SELECT `email` FROM `" . DB_PREFIX . "users` WHERE `email` = ? AND `temp_hash` = ?", array($this->model->escape($data['mail']), $data['hash']));
		if ($query->num_rows) {
			return $query->row;
		} else {
			return false;
		}
	}

	public function updatePassword($data)
	{
		$data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
		$this->model->query("UPDATE `" . DB_PREFIX . "users` SET `password` = ?, `temp_hash` = ? WHERE `email` = ? AND `temp_hash` = ? ", array($data['password'], '', $data['mail'], $data['hash']));
	}
	
	public function getTemplate($id)
	{
		$query = $this->model->query("SELECT * FROM `" . DB_PREFIX . "template` WHERE `template` = ? LIMIT 1", array($id));
		return $query->row;
	}
}