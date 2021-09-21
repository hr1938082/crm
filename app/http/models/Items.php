<?php

/**
* Items
*/
class Items extends Model
{
	public function getItems()
	{
		$query = $this->model->query("SELECT `id`, `name`, `price`, `description` FROM `" . DB_PREFIX . "items`");
		return $query->rows;
	}

	public function getItem($id)
	{
		$query = $this->model->query("SELECT * FROM `" . DB_PREFIX . "items` WHERE `id` = ? LIMIT 1", array((int)$id));
		return $query->row;
	}

	public function getCurrency()
	{
		$query = $this->model->query("SELECT `id`, `name` FROM `" . DB_PREFIX . "currency`");
		return $query->rows;
	}

	public function updateItem($data)
	{
		$query = $this->model->query("UPDATE `" . DB_PREFIX . "items` SET `name` = ?, `type` = ?, `unit` = ?, `currency` = ?, `price` = ?, `description` = ? WHERE `id` = ? ", array($data['name'], (int)$data['type'], $this->model->escape($data['unit']), (int)$data['currency'], (float)$data['price'], $data['description'], (int)$data['id']));
		if ($query->num_rows > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function createItem($data)
	{
		$query = $this->model->query("INSERT INTO `" . DB_PREFIX . "items` (`name`, `type`, `unit`, `currency`, `price`, `description`) VALUES (?, ?, ?, ?, ?, ?)", array($data['name'], (int)$data['type'], $this->model->escape($data['unit']), (int)$data['currency'], (float)$data['price'], $data['description']));
		if ($query->num_rows > 0) {
			return $this->model->last_id();
		} else {
			return false;
		}
	}

	public function deleteItem($id)
	{
		$query = $this->model->query("DELETE FROM `" . DB_PREFIX . "items` WHERE `id` = ?", array((int)$id ));
		if ($query->num_rows > 0) {
			return true;
		} else {
			return false;
		}
	}
}