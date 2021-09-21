<?php

/**
* Payment
*/
class Payment extends Model
{
	public function getInvoiceData($id)
	{
		$query = $this->model->query("SELECT i.*, c.firstname, c.company, c.email, cr.name AS currency, cr.abbr FROM `" . DB_PREFIX . "invoice` AS i LEFT JOIN `" . DB_PREFIX . "currency` AS cr ON cr.id = i.currency LEFT JOIN `" . DB_PREFIX . "contacts` AS c ON c.id = i.customer WHERE i.id = '".(int)$id."' LIMIT 1");
		
		return $query->row;
	}

	public function getPaymentData()
	{
		$query = $this->model->query("SELECT `username`, `mode`, `status` FROM `" . DB_PREFIX . "payment_gateway` WHERE `id` = ?", array(1));
		
		return $query->row;
	}

	public function getOrganisation()
	{
		$query = $this->model->query("SELECT * FROM `" . DB_PREFIX . "info` WHERE `id` = ?", array(1));	
		return $query->row;
	}

	public function checkTxnId($id)
	{
		$query = $this->model->query("SELECT `id` FROM `" . DB_PREFIX . "payments` WHERE `txn_id` = ?", array($id));
		if ($query->num_rows > 0) {
			print_r($query->rows);
			return true;
		} else {
			return false;
		}
	}

	public function getInvoiceAmount($id)
	{
		$query = $this->model->query("SELECT `name`, `email`, `amount`, `paid`, `due` FROM `" . DB_PREFIX . "invoice` WHERE `id` = '".(int)$id."' LIMIT 1");
		
		return $query->row;
	}

	public function updateInvoiceAmount($data)
	{
		$this->model->query("UPDATE `" . DB_PREFIX . "invoice` SET `paid` = ?, `due` = ?, `status` = ? WHERE `id` = ?", array($data['paid'], $data['due'], $data['status'], (int)$data['id']));
	}

	public function createPayment($data)
	{
		$query = $this->model->query("INSERT INTO `" . DB_PREFIX . "payments` (`invoice_id`, `txn_id`, `amount`, `currency`, `payer_email`, `paid_to`, `payment_date`) VALUES (?, ?, ?, ?, ?, ?, ?)", array($this->model->escape($data['item_number']), $data['txn_id'], $data['payment_gross'], $data['mc_currency'], $this->model->escape($data['payer_email']), $this->model->escape($data['business']), $this->model->escape($data['payment_date'])));


		if ($query->num_rows > 0) {
			return $this->model->last_id();
		} else {
			return false;
		}
	}

	public function getTemplate($name)
	{
		$query = $this->model->query("SELECT * FROM `" . DB_PREFIX . "template` WHERE `template` = ? LIMIT 1", array($name));
		return $query->row;
	}
}