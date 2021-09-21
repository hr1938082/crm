<?php

/**
* Ticket
*/
class Ticket extends model
{
	public function getTickets($email)
	{
		$query = $this->model->query("SELECT t.*, d.name AS department FROM `" . DB_PREFIX . "tickets` As t LEFT JOIN `" . DB_PREFIX . "departments` AS d ON d.id = t.department WHERE t.email = '".$email."' ORDER BY t.date_of_joining DESC");
		return $query->rows;
	}

	public function getDepartments()
	{
		$query = $this->model->query("SELECT * FROM `" . DB_PREFIX . "departments` WHERE `status` = ?", array(1));
		return $query->rows;
	}

	public function getInfo()
	{
		$query = $this->model->query("SELECT * FROM `" . DB_PREFIX . "info` WHERE `id` = ?", array(1));
		return $query->row;
	}

	public function getTemplate($template)
	{
		$query = $this->model->query("SELECT * FROM `" . DB_PREFIX . "template` WHERE `template` = ? LIMIT 1", array($template));
		return $query->row;
	}

	public function getTicket($data)
	{
		$query = $this->model->query("SELECT t.*, d.name AS department FROM `" . DB_PREFIX . "tickets` As t LEFT JOIN `" . DB_PREFIX . "departments` AS d ON d.id = t.department WHERE t.id = '".(int)$data['id']."' AND t.email = '".$data['user']['email']."' LIMIT 1");

		return $query->row;
	}

	public function getTicketView($data)
	{
		$query = $this->model->query("SELECT t.*, d.name AS department FROM `" . DB_PREFIX . "tickets` As t LEFT JOIN `" . DB_PREFIX . "departments` AS d ON d.id = t.department WHERE t.id = '".(int)$data['id']."' AND t.email = '".$data['email']."' LIMIT 1");

		return $query->row;
	}

	public function getMessages($id)
	{
		$query = $this->model->query("SELECT t.*, CONCAT(`firstname`, ' ', `lastname` ) AS `user` FROM `" . DB_PREFIX . "tickets_message` AS t LEFT JOIN `" . DB_PREFIX . "users` AS u ON u.user_id = t.user_id WHERE t.ticket_id = ? ORDER BY t.date_of_joining ASC", array((int)$id));
		
		return $query->rows;
	}

	public function updateTicket($data)
	{
		$query = $this->model->query("UPDATE `" . DB_PREFIX . "tickets` SET `reply_status` = ?, `status` = ?, `last_updated` = ? WHERE `id` = ? AND `email` = ? " , array(0, 0, (int)$data['id'], $data['last_updated'], $data['email']));
		
		if (!empty($data['descr'])) {
			$this->model->query("INSERT INTO `" . DB_PREFIX . "tickets_message` (`message`, `attached`, `message_by`, `ticket_id`, `user_id`) VALUES (?, ?, ?, ?, ?)", array($data['descr'], $data['attached'], 0, $data['id'], $data['user_id']));
		}
	}

	public function createTicket($data)
	{
		$query = $this->model->query("INSERT INTO `" . DB_PREFIX . "tickets` (`name`, `email`, `mobile`, `department`, `subject`, `priority`, `reply_status`, `status`, `last_updated`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)", array($this->model->escape($data['name']), $data['email'], $data['mobile'], $data['department'], $data['subject'], $data['priority'], 0, 0, $data['last_updated']));
		
		if ($query->num_rows > 0) {
			$id = $this->model->last_id();
			if (!empty($data['descr'])) { 
				$this->model->query("INSERT INTO `" . DB_PREFIX . "tickets_message` (`message`, `attached`, `message_by`, `ticket_id`) VALUES (?, ?, ?, ?)", array($data['descr'], $data['attached'], 0, $id));
			}
			return $id;

		} else {
			return false;
		}
	}
}