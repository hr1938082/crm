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
		$query = $this->model->query("UPDATE `" . DB_PREFIX . "info` SET `name` = ?, `legal_name` = ?, `language` = ?,  `logo` = ?,  `favicon` = ?, `email` = ?, `address` = ?, `phone` = ?, `fax` = ?, `signature` = ?, `invoice_setting` = ? WHERE `id` = ? ", array($this->model->escape($data['name']), $this->model->escape($data['legal_name']), $this->model->escape($data['language']), $this->model->escape($data['logo']), $this->model->escape($data['favicon']), $this->model->escape($data['email']), $data['address'], $this->model->escape($data['phone']), $this->model->escape($data['fax']), $data['signature'], $data['invoice'], 1));
		
		if ($query->num_rows > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function getCustomization()
	{
		$query = $this->model->query("SELECT `theme` FROM  `" . DB_PREFIX . "info` WHERE `id` = ? LIMIT 1", array(1) );
		return $query->row['theme'];
	}

	public function updateCustomization($data)
	{
		print_r($data);
		$query = $this->model->query("UPDATE `" . DB_PREFIX . "info` SET `theme` = ? WHERE `id` = ? ", array($data, 1));
	}
}