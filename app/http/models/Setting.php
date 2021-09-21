<?php

/**
* Setting
*/
class Setting extends Model
{
	
	public function getSettings($id)
	{

		$query = $this->model->query("SELECT * FROM `" . DB_PREFIX . "setting` WHERE `name` = ? LIMIT 1", array($id));
		return $query->row;
	}

	public function updateSetting($data)
	{
		$query = $this->model->query("UPDATE `" . DB_PREFIX . "setting` SET `data` = ?, `status` = ? WHERE `name` = ? ", array($data['data'], $data['status'], $data['setting']));
		if ($query->num_rows > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function DBdump()
	{
		return $this->model->dumpDatabase();
	}
}