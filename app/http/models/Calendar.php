<?php

/**
* Calendar
*/
class Calendar extends Model
{
	public function getEvents()
	{
		$query = $this->model->query("SELECT `id`, `title`, DATE_FORMAT(`start`, '%Y-%m-%d') AS start_date, DATE_FORMAT(`start`, '%H:%i:%s') AS start_time, DATE_FORMAT(`end`, '%Y-%m-%d') AS `end_date`, DATE_FORMAT(`end`, '%H:%i:%s') AS `end_time`, IF(allday = 1, 1, 0) AS `allDay`, `description` FROM `" . DB_PREFIX . "event`");
		return $query->rows;
	}
	
	public function getUserEvents($id)
	{
		$query = $this->model->query("SELECT `id`, `title`, DATE_FORMAT(`start`, '%Y-%m-%d') AS start_date, DATE_FORMAT(`start`, '%H:%i:%s') AS start_time, DATE_FORMAT(`end`, '%Y-%m-%d') AS `end_date`, DATE_FORMAT(`end`, '%H:%i:%s') AS `end_time`, IF(allday = 1, 1, 0) AS `allDay`, `description` FROM `" . DB_PREFIX . "event` WHERE `user_id` = ?", array((int)$id));
		return $query->rows;
	}

	public function getEvent($id)
	{
		$query = $this->model->query("SELECT * FROM `" . DB_PREFIX . "contacts` WHERE `id` = ? LIMIT 1", array((int)$id));
		return $query->row;
	}

	public function updateEvent($data)
	{
		$query = $this->model->query("UPDATE `" . DB_PREFIX . "event` SET `title` = ?, `description` = ?, `start` = ?, `end` = ?, `allday` = ?, `user_id` = ? WHERE `id` = ? ", array($data['title'], $data['description'], $this->model->escape($data['start']), $this->model->escape($data['end']), $this->model->escape($data['allday']), (int)$data['user_id'], (int)$data['id']));
		if ($query->num_rows > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function createEvent($data)
	{
		$query = $this->model->query("INSERT INTO `" . DB_PREFIX . "event` (`title`, `description`, `start`, `end`, `allday`, `user_id`) VALUES (?, ?, ?, ?, ?, ?)", array($data['title'], $data['description'], $data['start'], $data['end'], $this->model->escape($data['allday']), (int)$data['user_id']));
		if ($query->num_rows > 0) {
			return $this->model->last_id();
		} else {
			return false;
		}
	}

	public function dropEvent($data)
	{
		$query = $this->model->query("UPDATE `" . DB_PREFIX . "event` SET `start` = ? WHERE `id` = ? ", array($this->model->escape($data['start']), (int)$data['id']));
		if ($query->num_rows > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function deleteEvent($id)
	{
		$query = $this->model->query("DELETE FROM `" . DB_PREFIX . "event` WHERE `id` = ?", array((int)$id ));
		if ($query->num_rows > 0) {
			return true;
		} else {
			return false;
		}
	}
}