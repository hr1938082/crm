<?php

/**
* Template
*/
class Template extends Model
{
	public function getTemplate($id)
	{
		$query = $this->model->query("SELECT * FROM `" . DB_PREFIX . "template` WHERE `template` = ? LIMIT 1", array($id));
		return $query->row;
	}

	public function getTemplateMenu()
	{
		$query = $this->model->query("SELECT `id`, `template`, `name` FROM `" . DB_PREFIX . "template`");
		return $query->rows;
	}

	public function updateTemplate($data)
	{
		$query = $this->model->query("UPDATE `" . DB_PREFIX . "template` SET `name` = ?, `subject` = ?, `message` = ? WHERE `template` = ? ", array($data['name'], $data['subject'], $data['message'], $data['template']));
		if ($query->num_rows > 0) {
			return true;
		} else {
			return false;
		}
	}
}