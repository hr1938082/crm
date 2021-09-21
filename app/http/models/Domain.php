<?php

/**
* Domain
*/
class Domain extends Model
{
	public function getDomains($user = NULL)
	{
		if (!$user) {
			$query = $this->model->query("SELECT d.*, c.company FROM `" . DB_PREFIX . "domains` AS d LEFT JOIN `" . DB_PREFIX . "contacts` AS c ON c.id = d.customer");
		} else {
			$query = $this->model->query("SELECT d.*, c.company FROM `" . DB_PREFIX . "domains` AS d LEFT JOIN `" . DB_PREFIX . "contacts` AS c ON c.id = d.customer WHERE c.user_id = ?",array($user));
		}
		return $query->rows;
	}

	public function getDomain($id, $user = NULL)
	{
		if (!$user) {
			$query = $this->model->query("SELECT * FROM `" . DB_PREFIX . "domains` WHERE `id` = ? LIMIT 1", array((int)$id));
		} else {
			$query = $this->model->query("SELECT d.* FROM `" . DB_PREFIX . "domains` AS d LEFT JOIN `" . DB_PREFIX . "contacts` AS c ON c.id = d.customer WHERE d.id = ? AND c.user_id = ? LIMIT 1", array((int)$id, $user));
		}
		
		return $query->row;
	}

	public function getCustomers($user = NULL)
	{
		if (!$user) {
			$query = $this->model->query("SELECT `id`, `company` FROM `" . DB_PREFIX . "contacts`");
		} else {
			$query = $this->model->query("SELECT `id`, `company` FROM `" . DB_PREFIX . "contacts` WHERE `user_id` = ?",array($user));
		}
		return $query->rows;
	}

	public function getStaff()
	{
		$query = $this->model->query("SELECT `user_id`, concat(`firstname`, ' ', `lastname`) AS `name`, `user_name` FROM `" . DB_PREFIX . "users` WHERE user_role != ? ", array(1));
		return $query->rows;
	}

	public function getCurrency()
	{
		$query = $this->model->query("SELECT `id`, `name`, `abbr` FROM `" . DB_PREFIX . "currency`");
		return $query->rows;
	}

	public function updateDomain($data)
	{
		$query = $this->model->query("UPDATE `" . DB_PREFIX . "domains` SET `name` = ?, `url` = ?, `registration_date` = ?, `expiry_date` = ?, `provider` = ?, `hosting` = ?, `customer` = ?, `price` = ?, `currency` = ?, `status` = ?, `renew` = ?, `remark` = ? WHERE `id` = ?", array($this->model->escape($data['name']), $data['url'], $data['registration_date'], $data['expiry_date'], $data['provider'], $data['hosting'], $data['customer'], $data['price'], $data['currency'], $data['status'], $data['renew'], $data['remark'], (int)$data['id']));
		
		if ($query->num_rows > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function createDomain($data)
	{
		$query = $this->model->query("INSERT INTO `" . DB_PREFIX . "domains` (`name`, `url`, `registration_date`, `expiry_date`, `provider`, `hosting`, `customer`, `price`, `currency`, `status`, `renew`, `remark`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", array( $this->model->escape($data['name']), $data['url'], $data['registration_date'], $data['expiry_date'], $data['provider'], $data['hosting'], $data['customer'], $data['price'], $data['currency'], $data['status'], $data['renew'], $data['remark']));

		if ($query->num_rows > 0) {
			return $this->model->last_id();
		} else {
			return false;
		}
	}

	public function deleteDomain($id)
	{
		$query = $this->model->query("DELETE FROM `" . DB_PREFIX . "domains` WHERE `id` = ?", array((int)$id ));
		if ($query->num_rows > 0) {
			return true;
		} else {
			return false;
		}
	}
}