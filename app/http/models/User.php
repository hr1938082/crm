<?php
/**
* User Model
*/
class User extends Model
{
	public function allUsers()
	{
		$query = $this->model->query("SELECT u.*, ur.name AS `role` FROM `" . DB_PREFIX . "users` AS u LEFT JOIN `" . DB_PREFIX . "user_role` AS ur ON ur.id = u.user_role ORDER BY `date_of_joining` DESC");
		return $query->rows;
	}

	public function getUser($id)
	{
		$query = $this->model->query("SELECT * FROM `" . DB_PREFIX . "users` WHERE `user_id` = '".$id."' ");
		
		if ($query->num_rows > 0) {
			return $query->row;
		} else {
			return false;
		}
	}

	public function checkUserName($data)
	{
		$query = $this->model->query("SELECT count(*) AS total FROM `" . DB_PREFIX . "users` WHERE `user_name` = ? AND `email` != ?", array($this->model->escape($data['username']), $this->model->escape($data['email'])));
		if ( $query->num_rows > 0 ) {
			return $query->row['total'];
		} else {
			return false;
		}
	}

	public function checkUserEmail($email)
	{
		$query = $this->model->query("SELECT count(*) AS total FROM `" . DB_PREFIX . "users` WHERE `email` = ? ", array($this->model->escape($email)));
		if ($query->num_rows > 0) {
			return $query->row['total'];
		} else{
			return false;
		}
	}

	public function updateUser($data)
	{
		$query = $this->model->query("UPDATE `" . DB_PREFIX . "users` SET `user_role` = ?, `user_name` = ?, `firstname` = ?, `lastname` = ?, `mobile` = ?, `meta` = ?, `status` = ? WHERE `user_id` = ? AND `email` = ? " , array((int)$data['role'], $this->model->escape($data['username']), $this->model->escape($data['firstname']), $this->model->escape($data['lastname']), $this->model->escape($data['mobile']), $data['meta'], (int)$data['status'], (int)$data['id'], $this->model->escape($data['email'])));
		
		if ($query->num_rows > 0) { 
			return false;
		} else { 
			return true;
		}
	}

	public function createUser($data)
	{	
		$query = $this->model->query("INSERT INTO `" . DB_PREFIX . "users` (`user_role`, `user_name`, `firstname`, `lastname`, `email`, `mobile`, `meta`, `password`, `temp_hash`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)", array($this->model->escape((int)$data['role']), $this->model->escape($data['username']), $this->model->escape($data['firstname']), $this->model->escape($data['lastname']), $this->model->escape($data['email']), $this->model->escape($data['mobile']), $data['meta'], $data['password'], $data['hash']));
		
		if ($this->model->error()) {
			return $this->model->error();
		} else {
			return $this->model->last_id();
		}
	}

	public function deleteUser($id)
	{
		$query = $this->model->query("DELETE FROM `" . DB_PREFIX . "users` WHERE `user_id` = ?", array((int)$id));
		if ($query->num_rows > 0) { 
			return true;
		} else {
			return false;
		}
	}
	
	public function getTemplate($id)
	{
		$query = $this->model->query("SELECT * FROM `" . DB_PREFIX . "template` WHERE `template` = ? LIMIT 1", array($id));
		return $query->row;
	}

	public function userRole()
	{
		$query = $this->model->query("SELECT `id`, `name` FROM `" . DB_PREFIX . "user_role`");
		return $query->rows;
	}

	public function getRoles()
	{
		$query = $this->model->query("SELECT `id`, `name`, `description`, `date_of_joining` FROM `" . DB_PREFIX . "user_role`");
		return $query->rows;
	}

	public function getRole($id)
	{
		$query = $this->model->query("SELECT * FROM `" . DB_PREFIX . "user_role` WHERE `id` = ?", array((int)$id));
		return $query->row;
	}

	public function addUserRole($data)
	{
		$query = $this->model->query("INSERT INTO `" . DB_PREFIX . "user_role` (`name`, `description` ,`permission`) VALUES (?, ?, ?)", array($this->model->escape($data['name']), $data['description'], $data['permission']));

		return $this->model->last_id();
	}

	public function updateUserRole($data)
	{
		$query = $this->model->query("UPDATE `" . DB_PREFIX . "user_role` SET `name` = ?, `description` = ?, `permission` = ? WHERE `id` = ?", array($this->model->escape($data['name']), $data['description'], $data['permission'], (int)$data['id']));
		return true;
	}

	public function deleteRole($id)
	{
		$query = $this->model->query("DELETE FROM `" . DB_PREFIX . "user_role` WHERE `id` = ?", array((int)$id));
		if ($query->num_rows > 0) { 
			return true;
		} else {
			return false;
		}
	}
}