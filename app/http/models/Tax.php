<?php
 
/**
* Tax
*/
class Tax extends Model
{
	public function getTaxes()
	{
		$query = $this->model->query("SELECT `id`, `name`, `rate` FROM `" . DB_PREFIX . "taxes`");
		return $query->rows;
	}

	public function updateTax($data)
	{
		$query = $this->model->query("UPDATE `" . DB_PREFIX . "taxes` SET `name` = ?, `rate` = ? WHERE `id` = ? ", array($this->model->escape($data['name']), (float)$data['rate'], (int)$data['id']));
		if ($query->num_rows > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function createTax($data)
	{
		$query = $this->model->query("INSERT INTO `" . DB_PREFIX . "taxes` (`name`, `rate`) VALUES (?, ?)", array($this->model->escape($data['name']), (float)$data['rate']));
		if ($query->num_rows > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function deleteTax($id)
	{
		$query = $this->model->query("DELETE FROM `" . DB_PREFIX . "taxes` WHERE `id` = ?", array((int)$id ));
		if ($query->num_rows > 0) {
			return true;
		} else {
			return false;
		}
	}
}