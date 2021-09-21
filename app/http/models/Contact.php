<?php

/**
* Contact Model
*/
class Contact extends Model
{
	public function getContacts($user = false)
	{
		if (!$user) {
			$query = $this->model->query("SELECT `id`, `company`, `email`, `phone`, `expire`, `date_of_joining` FROM `" . DB_PREFIX . "contacts` ORDER BY `date_of_joining` DESC");
		} else {
			$query = $this->model->query("SELECT `id`, `company`, `email`, `phone`, `expire`, `date_of_joining` FROM `" . DB_PREFIX . "contacts` WHERE `user_id` = ? ORDER BY date_of_joining DESC", array($user));
		}
		return $query->rows;
	}

	public function getContact($id, $user = false)
	{
		if (!$user) {
			$query = $this->model->query("SELECT c.*, u.user_name AS username FROM `" . DB_PREFIX . "contacts` AS c LEFT JOIN `" . DB_PREFIX . "users` AS u ON u.user_id = c.user_id WHERE `id` = ? LIMIT 1", array((int)$id));
			return $query->row;
		} else {
			$query = $this->model->query("SELECT * FROM `" . DB_PREFIX . "contacts` WHERE `id` = ? AND `user_id` = ? LIMIT 1", array((int)$id, $user));
			return $query->row;
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

	public function getStaff()
	{
		$query = $this->model->query("SELECT `user_id`, concat(`firstname`, ' ', `lastname`) AS `name`, `user_name` FROM `" . DB_PREFIX . "users` WHERE user_role != ? ", array(1));
		return $query->rows;
	}

	public function getInvoices($id)
	{
		$query = $this->model->query("SELECT i.id, i.amount, i.due, i.duedate, i.date_of_joining, i.status, cr.abbr AS `abbr` FROM `" . DB_PREFIX . "invoice` AS i LEFT JOIN `" . DB_PREFIX . "currency` AS cr ON i.currency = cr.id WHERE `customer` = ? ORDER BY i.date_of_joining DESC LIMIT 10", array($id));
		return $query->rows;
	}

	public function getQuotes($id)
	{
		$query = $this->model->query("SELECT p.id, p.project_name, p.total, p.date, p.expiry, cr.abbr AS `abbr` FROM `" . DB_PREFIX . "proposal` AS p LEFT JOIN `" . DB_PREFIX . "currency` AS cr ON p.currency = cr.id WHERE p.customer = ? ORDER BY p.date_of_joining DESC LIMIT 10", array($id));
		return $query->rows;
	}

	public function getClient($email)
	{
		$query = $this->model->query("SELECT * FROM `" . DB_PREFIX . "clients` WHERE `email` = ? LIMIT 1", array($email));
		return $query->row;
	}

	public function getClientActivity($id)
	{
		$query = $this->model->query("SELECT * FROM `" . DB_PREFIX . "client_activity` WHERE `type_id` = ? ORDER BY `date_of_joining` DESC", array($id));
		return $query->rows;
	}

	public function updateContact($data)
	{
		$query = $this->model->query("UPDATE `" . DB_PREFIX . "contacts` SET `salutation` = ?, `firstname` = ?, `lastname` = ?, `company` = ?, `email` = ?, `phone` = ?, `website` = ?, `address` = ?, `country` = ?, `persons` = ?, `remark` = ?, `marketing` = ?, `expire` = ?, `user_id` = ? WHERE `id` = ? ", array($this->model->escape($data['salutation']), $this->model->escape($data['firstname']), $this->model->escape($data['lastname']), $this->model->escape($data['company']), $this->model->escape($data['email']), $this->model->escape($data['phone']), $this->model->escape($data['website']), $data['address'], $this->model->escape($data['country']), $data['person'], $data['remark'], $data['marketing'], $data['expire'], $data['staff'], (int)$data['id']));
		if (!empty($data['client']['client_id'])) {
			$this->model->query("UPDATE `" . DB_PREFIX . "clients` SET `status` = ? WHERE `id` = ? ", array((int)$data['client']['status'], (int)$data['client']['client_id']));
		}
	}

	public function createContact($data)
	{
		$query = $this->model->query("INSERT INTO `" . DB_PREFIX . "contacts` (`salutation`, `firstname`, `lastname`, `company`, `email`, `phone`, `website`, `address`, `country`, `persons`, `remark`, `marketing`, `expire`, `user_id`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", array($this->model->escape($data['salutation']), $this->model->escape($data['firstname']), $this->model->escape($data['lastname']), $this->model->escape($data['company']), $this->model->escape($data['email']), $this->model->escape($data['phone']), $this->model->escape($data['website']), $data['address'], $this->model->escape($data['country']), $data['person'], $data['remark'], $data['marketing'], $data['expire'], $data['staff']));
		
		if ($query->num_rows > 0) {
			return $this->model->last_id();
		} else {
			return false;
		}
	}

	public function importContact($data)
	{
		$query = $this->model->importQuery("INSERT INTO `" . DB_PREFIX . "contacts` (`salutation`, `firstname`, `lastname`, `company`, `email`, `phone`, `website`, `address`, `country`, `expire`) VALUES ".$data);
		if ($query > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function emailLog($data)
	{
		$query = $this->model->query("INSERT INTO `" . DB_PREFIX . "email_logs` (`email_to`, `email_bcc`, `subject`, `message`, `type`, `type_id`, `user_id`) VALUES (?, ?, ?, ?, ?, ?, ?)", array( $data['to'], $data['bcc'], $data['subject'], $data['message'], $data['type'], $data['type_id'], $data['user_id']));
		if ($query->num_rows > 0) {
			return $this->model->last_id();
		} else {
			return false;
		}
	}

	public function deleteContact($id)
	{
		$query = $this->model->query("SELECT `email` FROM `" . DB_PREFIX . "contacts` WHERE `id` = ?", array((int)$id ));
		$email = $query->row['email'];
		$this->model->query("DELETE FROM `" . DB_PREFIX . "contacts` WHERE `id` = ?", array((int)$id));
		$this->model->query("DELETE FROM `" . DB_PREFIX . "clients` WHERE `email` = ?", array($email));
		$this->model->query("DELETE FROM `" . DB_PREFIX . "client_activity` WHERE `type_id` = ?", array((int)$id));
		return true;
	}
	
	public function deleteContactByLead($lead)
	{
		$query = $this->model->query("SELECT `email` FROM `" . DB_PREFIX . "contacts` WHERE `lead_id` = ?", array((int)$lead));
		$email = $query->row['email'];
		$this->model->query("DELETE FROM `" . DB_PREFIX . "contacts` WHERE `lead_id` = ?", array((int)$lead));
		$this->model->query("DELETE FROM `" . DB_PREFIX . "clients` WHERE `email` = ?", array($email));
		$this->model->query("DELETE FROM `" . DB_PREFIX . "client_activity` WHERE `type_id` = ?", array((int)$lead));
		return true;
	}

	public function getClients()
	{
		$query = $this->model->query("SELECT * FROM `" . DB_PREFIX . "clients`");
		return $query->rows;
	}

	public function getClientByID($id)
	{
		$query = $this->model->query("SELECT * FROM `" . DB_PREFIX . "clients` WHERE id = ?", array((int)$id));
		return $query->row;
	}

	public function updateClient($data)
	{
		$query = $this->model->query("UPDATE `" . DB_PREFIX . "clients` SET `name` = ?, `mobile` = ?, `status` = ? WHERE `id` = ? ", array($this->model->escape($data['name']), $this->model->escape($data['mobile']), (int)$data['status'], (int)$data['id']));
	}

	public function deleteClient($id)
	{
		$query = $this->model->query("DELETE FROM `" . DB_PREFIX . "clients` WHERE `id` = ?", array((int)$id ));
		if ($query->num_rows > 0) {
			return true;
		} else {
			return false;
		}
	}
}