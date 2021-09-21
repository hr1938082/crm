<?php

/**
* Profile
*/
class Profile extends Model
{
	public function getCustomer($id)
	{
		$query = $this->model->query("SELECT * FROM `" . DB_PREFIX . "contacts` WHERE `id` = ? LIMIT 1", array($id));

		return $query->row;
	}

	public function updateContact($data)
	{
		$query = $this->model->query("UPDATE `" . DB_PREFIX . "contacts` SET `salutation` = ?, `firstname` = ?, `lastname` = ?, `company` = ?, `phone` = ?, `website` = ?, `address` = ?, `country` = ?, `marketing` = ? WHERE `id` = ? ", array($this->model->escape($data['salutation']), $this->model->escape($data['firstname']), $this->model->escape($data['lastname']), $this->model->escape($data['company']), $this->model->escape($data['phone']), $this->model->escape($data['website']), $data['address'], $this->model->escape($data['country']), $data['marketing'], (int)$data['id']));
		return true;
	}

	public function updateProfile($data)
	{
		$query = $this->model->query("UPDATE `" . DB_PREFIX . "clients` SET `name` = ?, `mobile` = ? WHERE `id` = ? AND `email` = ?", array($this->model->escape($data['name']), $this->model->escape($data['mobile']), (int)$data['id'], $this->model->escape($data['email'])));
		if ($this->model->error()) {
			return $this->model->error();
		} else {
			return true;
		}
	}

	public function updatePassword($data)
	{
		$query = $this->model->query("UPDATE `" . DB_PREFIX . "clients` SET `password` = ? WHERE `id` = ? AND `email` = ?" , array($this->model->escape($data['password']), (int)$data['id'], $this->model->escape($data['email'])));
		if ($query->num_rows > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function getUserData($data)
	{
		 $query = $this->model->query("SELECT `password` FROM `" . DB_PREFIX . "clients` WHERE `id` = ? AND `email` = ? LIMIT 1", array($this->model->escape($data['id']), $this->model->escape($data['email'])));
		if ($query->num_rows > 0) {
			return  $query->row['password'];
		} else {
			return false;
		}
	}

	public function clientActivity($data)
	{
		$this->model->query("INSERT INTO `" . DB_PREFIX . "client_activity` (`name`, `type_id`, `ip`) VALUES (?, ?, ?) ", array($this->model->escape($data['name']), $data['type_id'], $data['ip']));
	}
}