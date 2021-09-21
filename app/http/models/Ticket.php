<?php

/**
* Ticket
*/
class Ticket extends Model
{

	public function getTickets($user = NULL)
	{
		if (!$user) {
			$query = $this->model->query("SELECT t.*, d.name AS department FROM `" . DB_PREFIX . "tickets` As t LEFT JOIN `" . DB_PREFIX . "departments` AS d ON d.id = t.department ORDER BY t.date_of_joining DESC");
		} else {
			$query = $this->model->query("SELECT t.*, d.name AS department FROM `" . DB_PREFIX . "tickets` As t LEFT JOIN `" . DB_PREFIX . "departments` AS d ON d.id = t.department WHERE t.user_id = ? ORDER BY t.date_of_joining DESC", array($user));
		}
		return $query->rows;
	}

	public function getOpenTickets()
	{
		$query = $this->model->query("SELECT t.*, d.name AS department FROM `" . DB_PREFIX . "tickets` As t LEFT JOIN `" . DB_PREFIX . "departments` AS d ON d.id = t.department WHERE t.status = 0 ORDER BY t.date_of_joining DESC");
		return $query->rows;
	}

	public function getClosedTickets()
	{
		$query = $this->model->query("SELECT t.*, d.name AS department FROM `" . DB_PREFIX . "tickets` As t LEFT JOIN `" . DB_PREFIX . "departments` AS d ON d.id = t.department WHERE t.status = 1 ORDER BY t.date_of_joining DESC");
		return $query->rows;
	}

	public function getTicketCount()
	{
		$query = $this->model->query("SELECT COUNT(*) AS count FROM `" . DB_PREFIX . "tickets` WHERE `status` = ?", array(1));
		$data['closed'] = $query->row['count'];

		$query = $this->model->query("SELECT COUNT(*) AS count FROM `" . DB_PREFIX . "tickets` WHERE `status` = ?", array(0));
		$data['open'] = $query->row['count'];

		$query = $this->model->query("SELECT COUNT(*) AS count FROM `" . DB_PREFIX . "tickets`");
		$data['all'] = $query->row['count'];

		return $data;
	}

	public function getStaff()
	{
		$query = $this->model->query("SELECT `user_id`, concat(`firstname`, ' ', `lastname`) AS `name`, `user_name` FROM `" . DB_PREFIX . "users` WHERE user_role != ? ", array(1));
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

	public function getTicket($id, $user = NULL)
	{
		if (!$user) {
			$query = $this->model->query("SELECT t.*, d.name AS department FROM `" . DB_PREFIX . "tickets` As t LEFT JOIN `" . DB_PREFIX . "departments` AS d ON d.id = t.department WHERE t.id = '".(int)$id."' LIMIT 1");
		} else {
			$query = $this->model->query("SELECT t.*, d.name AS department FROM `" . DB_PREFIX . "tickets` As t LEFT JOIN `" . DB_PREFIX . "departments` AS d ON d.id = t.department WHERE t.id = '".(int)$id."' AND t.user_id = '".$user."' LIMIT 1");
		}
		return $query->row;
	}

	public function getMessages($id)
	{
		$query = $this->model->query("SELECT t.*, CONCAT(`firstname`, ' ', `lastname` ) AS `user` FROM `" . DB_PREFIX . "tickets_message` AS t LEFT JOIN `" . DB_PREFIX . "users` AS u ON u.user_id = t.user_id WHERE t.ticket_id = ? ORDER BY t.date_of_joining ASC", array((int)$id));
		
		return $query->rows;
	}

	public function updateTicket($data)
	{
		$query = $this->model->query("UPDATE `" . DB_PREFIX . "tickets` SET `reply_status`= ?, `remark` = ?, `status` = ?, `user_id` = ?, `last_updated` = ? WHERE `id` = ?" , array(1, $data['remark'], (int)$data['status'], $data['staff'], $data['last_updated'], (int)$data['id']));

		if (!empty($data['descr'])) {
			$this->model->query("INSERT INTO `" . DB_PREFIX . "tickets_message` (`message`, `attached`, `message_by`, `ticket_id`, `user_id`) VALUES (?, ?, ?, ?, ?)", array($data['descr'], $data['attached'], 1, $data['id'], $data['user_id']));
		}
	}

	public function createTicket($data)
	{
		$query = $this->model->query("INSERT INTO `" . DB_PREFIX . "tickets` (`name`, `email`, `mobile`, `department`, `subject`, `priority`, `reply_status`, `remark`, `status`, `user_id`, `last_updated`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", array($this->model->escape($data['name']), $data['email'], $data['mobile'], $data['department'], $data['subject'], $data['priority'], 1, $data['remark'], 0, $data['staff'], $data['last_updated']));
		
		if ($query->num_rows > 0) {
			$id = $this->model->last_id();
			if (!empty($data['descr'])) { 
				$this->model->query("INSERT INTO `" . DB_PREFIX . "tickets_message` (`message`, `attached`, `message_by`, `ticket_id`, `user_id`) VALUES (?, ?, ?, ?, ?)", array($data['descr'], $data['attached'], 1, $id, $data['user_id']));
			}
			return $id;

		} else {
			return false;
		}
	}

	public function deleteTicket($id)
	{
		$query = $this->model->query("DELETE FROM `" . DB_PREFIX . "tickets` WHERE `id` = ?", array((int)$id ));
		$query = $this->model->query("DELETE FROM `" . DB_PREFIX . "tickets_message` WHERE `ticket_id` = ?", array((int)$id ));
		if ($query->num_rows > 0) {
			return true;
		} else {
			return false;
		}
	}
}