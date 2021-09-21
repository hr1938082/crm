<?php

/**
* Invoice Model
*/
class Invoice extends Model
{
	public function getInvoices($customer)
	{
		$query = $this->model->query("SELECT i.*, c.company, cr.abbr AS `abbr` FROM `" . DB_PREFIX . "invoice` AS i LEFT JOIN `" . DB_PREFIX . "contacts` AS c ON c.id = i.customer LEFT JOIN `" . DB_PREFIX . "currency` AS cr ON i.currency = cr.id WHERE i.customer = ? AND i.inv_status = 1 ORDER BY i.id DESC", array((int)$customer));
		return $query->rows;
	}

	public function getOrganization()
	{
		$query = $this->model->query("SELECT * FROM `" . DB_PREFIX . "info` WHERE `id` = ?", array(1));
		if ($query->num_rows > 0) {
			return $query->row;
		} else {
			return '';
		}
	}

	public function getInovice($id)
	{
		$query = $this->model->query("SELECT * FROM `" . DB_PREFIX . "invoice` WHERE `id` = ? AND i.inv_status = 1 LIMIT 1", array((int)$id));
		
		if ($query->num_rows > 0) {
			return $query->row;
		} else {
			return false;
		}
	}

	public function getInoviceView($data)
	{
		$query = $this->model->query("SELECT i.*, c.company, c.email, c.address, p.name AS payment, cr.name AS currency_name, cr.abbr AS currency_abbr, ps.name AS `payment_status` FROM `" . DB_PREFIX . "invoice` AS i LEFT JOIN `" . DB_PREFIX . "contacts` AS c ON i.customer = c.id LEFT JOIN `" . DB_PREFIX . "payment_type` AS p ON i.paymenttype = p.id LEFT JOIN `" . DB_PREFIX . "payment_status` AS ps ON i.status = ps.id LEFT JOIN `" . DB_PREFIX . "currency` AS cr ON i.currency = cr.id WHERE i.id = ? AND i.customer = ? AND i.inv_status = 1 LIMIT 1", array((int)$data['id'], (int)$data['customer']));
		
		if ($query->num_rows > 0) {
			return $query->row;
		} else {
			return false;
		}
	}

	public function getAttachments($id)
	{
		$query = $this->model->query("SELECT `id`, `file_name` FROM `" . DB_PREFIX . "attached_files` WHERE `file_type` = ? AND `file_type_id` = ?", array('invoice', $id));
		return $query->rows;
	}

	public function getPayments($id)
	{
		$query = $this->model->query("SELECT p.id, p.amount, p.method, p.payment_date, pm.name AS method_name FROM `" . DB_PREFIX . "payments` AS p LEFT JOIN `" . DB_PREFIX . "payment_type` AS pm ON pm.id = p.method WHERE `invoice_id` = ?", array((int)$id));
		return $query->rows;
	}

	public function paymentType()
	{
		$query = $this->model->query("SELECT `id`, `name` FROM `" . DB_PREFIX . "payment_type` WHERE `status` = ? ", array(1));
		return $query->rows;
	}

	public function getTaxes()
	{
		$query = $this->model->query("SELECT `id`, `name`, `rate` FROM `" . DB_PREFIX . "taxes`");
		return $query->rows;
	}

	public function getItems()
	{
		$query = $this->model->query("SELECT `id`, `name` AS `label`, `price` AS `cost`, `description` AS `desc` FROM `" . DB_PREFIX . "items`");
		return $query->rows;
	}

	public function getCustomers()
	{
		$query = $this->model->query("SELECT `id`, `company` FROM `" . DB_PREFIX . "contacts`");
		return $query->rows;
	}

	public function getPaymentStatus()
	{
		$query = $this->model->query("SELECT `id`, `name` FROM `" . DB_PREFIX . "payment_status`");
		return $query->rows;
	}

	public function getCurrency()
	{
		$query = $this->model->query("SELECT `id`, `name`, `abbr` FROM `" . DB_PREFIX . "currency`");
		return $query->rows;
	}

	public function updateInvoice($data)
	{
		$query = $this->model->query("UPDATE `" . DB_PREFIX . "invoice` SET `customer` = ?, `duedate` = ?, `paiddate` = ?, `currency` = ?, `paymenttype` = ?, `items` = ?, `subtotal` = ?, `tax` = ?, `discount` = ?, `discount_type` = ?, `discount_value` = ?, `amount` = ?, `paid` = ?, `due` = ?, `note` = ?, `tc` = ?, `status` = ? WHERE `id` = ?", array((int)$data['customer'], $this->model->escape($data['duedate']), $this->model->escape($data['paiddate']), (int)$data['currency'], (int)$data['paymenttype'], $data['item'], $data['subtotal'], $data['tax'], $data['discount'], $data['discounttype'], $data['discount_value'], $data['amount'], $data['paid'], $data['due'], $data['note'], $data['tc'], $data['status'], (int)$data['id']));

		if ($query->num_rows > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function createInvoice($data)
	{
		$query = $this->model->query("INSERT INTO `" . DB_PREFIX . "invoice` (`customer`, `duedate`, `paiddate`, `currency`, `paymenttype`, `items`, `subtotal`, `tax`, `discount`, `discount_type`, `discount_value`, `amount`, `paid`, `due`, `note`, `tc`, `status`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", array( (int)$data['customer'], $this->model->escape($data['duedate']), $this->model->escape($data['paiddate']), (int)$data['currency'], (int)$data['paymenttype'], $data['item'], $data['subtotal'], $data['tax'], $data['discount'], $data['discounttype'], $data['discount_value'], $data['amount'], $data['paid'], $data['due'], $data['note'], $data['tc'], $data['status']));
		if ($query->num_rows > 0) {
			return $this->model->last_id();
		} else {
			return false;
		}
	}
	
	public function deleteInvoice($id)
	{
		$query = $this->model->query("DELETE FROM `" . DB_PREFIX . "invoice` WHERE `id` = ?", array((int)$id ));
		if ($query->num_rows > 0) {
			return true;
		} else {
			return false;
		}
	}
}