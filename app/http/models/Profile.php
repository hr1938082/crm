<?php

/**
* Profile Model
*/
class Profile extends Model
{
	public function getProfile($id)
	{
		$query = $this->model->query("SELECT `user_id`, `user_name`, `firstname`, `lastname`, `email`, `mobile` FROM `" . DB_PREFIX . "users` WHERE `user_id` = ? LIMIT 1", array($this->model->escape($id)));
		
		if ($query->num_rows > 0) {
			return $query->row;
		} else {
			return false;
		}
	}

	public function updateProfile($data)
	{
		$query = $this->model->query("UPDATE `" . DB_PREFIX . "users` SET `user_name` = ?, `firstname` = ?, `lastname` = ?, `mobile` = ? WHERE `user_id` = ? AND `email` = ?", array($this->model->escape($data['username']), $this->model->escape($data['firstname']), $this->model->escape($data['lastname']), $this->model->escape($data['mobile']), (int)$data['user_id'], $this->model->escape($data['email'])));
		if ($this->model->error()) {
			return $this->model->error();
		} else {
			return true;
		}
	}

	public function checkUserName($username, $email)
	{
		$query = $this->model->query("SELECT count(*) AS total FROM `" . DB_PREFIX . "users` WHERE `user_name` = ? AND `email` != ?", array($this->model->escape($username), $this->model->escape($email)));
		if ($query->num_rows > 0) {
			return $query->row['total'];
		} else {
			return false;
		}
	}

	public function updatePassword($data)
	{
		$query = $this->model->query("UPDATE `" . DB_PREFIX . "users` SET `password` = ? WHERE `user_id` = ? " , array($this->model->escape($data['password']), (int)$data['user_id']));
		if ($query->num_rows > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function getUserData($id)
	{
		 $query = $this->model->query("SELECT `password` FROM `" . DB_PREFIX . "users` WHERE `user_id` = ? LIMIT 1", array($this->model->escape($id)));
		if ($query->num_rows > 0) {
			return  $query->row['password'];
		} else {
			return false;
		}
	}
}