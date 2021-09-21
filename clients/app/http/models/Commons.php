<?php

/**
* Commmons Model
*/
class Commons extends Model
{
	public function getUserData($id)
	{
		$query = $this->model->query("SELECT `id`, `name`, `email`, `mobile` FROM `" . DB_PREFIX . "clients` WHERE `id` = ? LIMIT 1", array((int)$id));
		if ($query->num_rows > 0) {
			return $query->row;
		} else {
			return '';
		}
	}

	public function getInfo()
	{
		$query = $this->model->query("SELECT * FROM `" . DB_PREFIX . "info` WHERE `id` = ?", array(1));
		if ($query->num_rows > 0) {
			return $query->row;
		} else {
			return '';
		}
	}

	public function getInvoiceBasics()
	{
		$query = $this->model->query("SELECT `logo`, `favicon`, `name`, `address`, `currency` FROM `" . DB_PREFIX . "info` WHERE `id` = ?", array(1));
		if ($query->num_rows > 0) {
			return $query->row;
		} else {
			return '';
		}
	}

	public function insertAttchedFile($data)
	{
		$query = $this->model->query("INSERT INTO `" . DB_PREFIX . "attached_files` (`file_name`, `file_type`, `file_type_id`) VALUES (?, ?, ?) ", array($this->model->escape($data['name']), $data['type'], $data['type_id']));
	}

	public function deleteAttchedFile($data)
	{
		$query = $this->model->query("DELETE FROM `" . DB_PREFIX . "attached_files` WHERE `file_name` = ? AND `file_type` = ?" , array($this->model->escape($data['name']), $data['type']));

	}}