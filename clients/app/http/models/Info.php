<?php

/**
* Info Model
*/

class Info extends Model
{
	public function getInfo()
	{
		$query = $this->model->query("SELECT * FROM  `" . DB_PREFIX . "info` WHERE `id` = ? LIMIT 1", array(1) );
		return $query->row;
	}

	public function updateInfo($data)
	{
		$query = $this->model->query("UPDATE `" . DB_PREFIX . "info` SET `url` = ?, `name` = ?, `legal_name` = ?,  `logo` = ?,  `favicon` = ?, `email` = ?, `address` = ?, `phone` = ?, `fax` = ?, `currency` = ? WHERE `id` = ? ", array($this->model->escape($data['url']), $this->model->escape($data['name']), $this->model->escape($data['legal_name']), $this->model->escape($data['logo']), $this->model->escape($data['favicon']), $this->model->escape($data['email']), $data['address'], $this->model->escape($data['phone']), $this->model->escape($data['fax']), $this->model->escape($data['currency']), 1));
			print_r($this->model->error());
		if ($query->num_rows > 0) {
			return true;
		} else {
			return false;
		}
	}
}