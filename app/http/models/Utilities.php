<?php

/**
* Utilities
*/
class Utilities extends Model
{
	public function getEmailLogs()
	{
		$query = $this->model->query("SELECT ut.*, u.user_name FROM `" . DB_PREFIX . "email_logs` AS ut LEFT JOIN `" . DB_PREFIX . "users` AS u ON u.user_id = ut.user_id ORDER BY ut.date_of_joining DESC");
		return $query->rows;
	}

	public function getCronLogs()
	{
		$query = $this->model->query("SELECT * FROM `" . DB_PREFIX . "recurring_log` ORDER BY date_of_joining DESC");
		return $query->rows;
	}
}