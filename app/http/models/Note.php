<?php

/**
* Note
*/
class Note extends model
{
	public function getNotes()
	{
		$query = $this->model->query("SELECT * FROM `" . DB_PREFIX . "notes` ORDER BY `date_of_joining` DESC");
		return $query->rows;
	}

	public function getUserNotes($user_id)
	{
		$query = $this->model->query("SELECT * FROM `" . DB_PREFIX . "notes` WHERE `user_id` = ?", array((int)$user_id));
		return $query->rows;
	}

	public function getNote($id)
	{
		$query = $this->model->query("SELECT * FROM `" . DB_PREFIX . "notes` WHERE `id` = ? LIMIT 1", array((int)$id));
		return $query->row;
	}

	public function getUserNote($id, $user_id)
	{
		$query = $this->model->query("SELECT * FROM `" . DB_PREFIX . "notes` WHERE `id` = ? AND `user_id` = ? LIMIT 1", array((int)$id, (int)$user_id));
		return $query->row;
	}

	public function updateNote($data)
	{
		$query = $this->model->query("UPDATE `" . DB_PREFIX . "notes` SET `title` = ?, `description` = ?, `color` = ?, `background` = ?, `status` = ? WHERE `id` = ? ", array($data['title'], $data['descr'], $data['color'], $data['background'], (int)$data['status'], (int)$data['id']));
		if ($query->num_rows > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function createNote($data)
	{
		$query = $this->model->query("INSERT INTO `" . DB_PREFIX . "notes` (`title`, `description`, `color`, `background`, `status`, `user_id`) VALUES (?, ?, ?, ?, ?, ?)", array($data['title'], $data['descr'], $data['color'], $data['background'], (int)$data['status'], (int)$data['user_id']));
		if ($query->num_rows > 0) {
			return $this->model->last_id();
		} else {
			return false;
		}
	}

	public function deleteNote($id)
	{
		$query = $this->model->query("DELETE FROM `" . DB_PREFIX . "notes` WHERE `id` = ?", array((int)$id ));
		if ($query->num_rows > 0) {
			return true;
		} else {
			return false;
		}
	}
}