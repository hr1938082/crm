<?php

/**
* Subscriber Model
*/
class Subscriber extends Model
{
	public function allSubscribers()
	{
		$query = $this->model->query("SELECT * FROM `" . DB_PREFIX . "subscribe` ORDER BY `date_of_joining` DESC");
		return $query->rows;
	}

	public function getSubscriber($id)
	{
		$query = $this->model->query("SELECT * FROM `" . DB_PREFIX . "subscribe` WHERE `id` = ? LIMIT 1", array($this->model->escape($id)));
		if ($query->num_rows > 0) {
			return $query->row;
		} else {
			return false;
		}
	}

	public function updateSubscriber($data)
	{
		$query = $this->model->query("UPDATE `" . DB_PREFIX . "subscribe` SET `email` = ?, `status` = ? WHERE `id` = ?" , array($this->model->escape($data['email']), (int)$data['status'], (int)$data['id']));
		return true;
	}

	public function createSubscriber($data)
	{
		$query = $this->model->query("INSERT INTO `" . DB_PREFIX . "subscribe` (`email`, `status`) VALUES (?, ?)", array($this->model->escape($data['email']), 1));
		if ($query->num_rows > 0) {
			return $this->model->last_id();
		} else {
			return false;
		}
	}

	public function deleteSubscriber($id)
	{
		$query = $this->model->query("DELETE FROM `" . DB_PREFIX . "subscribe` WHERE `id` = ?", array((int)$id));
		if ($query->num_rows > 0) {
			return true;
		} else {
			return false;
		}
	}
}