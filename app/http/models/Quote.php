<?php

/**
* Proposal Model
*/
class Quote extends Model
{

	public function getQuotes($user = false)
	{
		if (!$user) {
			$query = $this->model->query("SELECT p.*, c.company AS company FROM `" . DB_PREFIX . "proposal` AS p LEFT JOIN `" . DB_PREFIX . "contacts` AS c ON c.id = p.customer ORDER BY p.date_of_joining DESC");
		} else {
			$query = $this->model->query("SELECT p.*, c.company AS company FROM `" . DB_PREFIX . "proposal` AS p LEFT JOIN `" . DB_PREFIX . "contacts` AS c ON c.id = p.customer WHERE c.user_id = ? ORDER BY p.date_of_joining DESC", array($user));
		}
		
		return $query->rows;
	}

	public function getQuote($id, $user = false)
	{
		if (!$user) {
			$query = $this->model->query("SELECT * FROM `" . DB_PREFIX . "proposal` WHERE `id` = ? LIMIT 1", array((int)$id));
		} else {
			$query = $this->model->query("SELECT p.* FROM `" . DB_PREFIX . "proposal` AS p LEFT JOIN `" . DB_PREFIX . "contacts` AS c ON p.customer = c.id WHERE p.id = ? AND c.user_id = ? LIMIT 1", array((int)$id, $user));
		}
		
		if ($query->num_rows > 0) {
			return $query->row;
		} else {
			return false;
		}
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

	public function getCustomers($user = NULL)
	{
		if (!$user) {
			$query = $this->model->query("SELECT `id`, `company` FROM `" . DB_PREFIX . "contacts`");
		} else {
			$query = $this->model->query("SELECT `id`, `company` FROM `" . DB_PREFIX . "contacts` WHERE `user_id` = ?",array($user));
		}
		return $query->rows;
	}

	public function getQuoteView($id, $user = false)
	{
		if (!$user) {
			$query = $this->model->query("SELECT p.*, c.company, c.email, c.address, cr.name AS currency_name, cr.abbr AS currency_abbr, pt.name AS `payment_method` FROM `" . DB_PREFIX . "proposal` AS p LEFT JOIN `" . DB_PREFIX . "contacts` AS c ON p.customer = c.id LEFT JOIN `" . DB_PREFIX . "payment_type` AS pt ON p.paymenttype = pt.id LEFT JOIN `" . DB_PREFIX . "currency` AS cr ON p.currency = cr.id WHERE p.id = ? LIMIT 1", array((int)$id));
		} else {
			$query = $this->model->query("SELECT p.*, c.company, c.email, c.address, cr.name AS currency_name, cr.abbr AS currency_abbr, pt.name AS `payment_method` FROM `" . DB_PREFIX . "proposal` AS p LEFT JOIN `" . DB_PREFIX . "contacts` AS c ON p.customer = c.id LEFT JOIN `" . DB_PREFIX . "payment_type` AS pt ON p.paymenttype = pt.id LEFT JOIN `" . DB_PREFIX . "currency` AS cr ON p.currency = cr.id WHERE p.id = ? AND c.user_id = ? LIMIT 1", array((int)$id, $user));
		}
		
		if ($query->num_rows > 0) {
			return $query->row;
		} else {
			return false;
		}
	}

	public function getInoviceView($id)
	{
		$query = $this->model->query("SELECT i.*, c.company, c.email, p.name AS payment, cr.name AS currency_name, cr.abbr AS currency_abbr FROM `" . DB_PREFIX . "invoice` AS i LEFT JOIN `" . DB_PREFIX . "contacts` AS c ON i.customer = c.id LEFT JOIN `" . DB_PREFIX . "payment_type` AS p ON i.paymenttype = p.id LEFT JOIN `" . DB_PREFIX . "currency` AS cr ON i.currency = cr.id WHERE i.id = ? LIMIT 1", array((int)$id));
		
		if ($query->num_rows > 0) {
			return $query->row;
		} else {
			return false;
		}
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

	public function createQuote($data)
	{
		$query = $this->model->query("INSERT INTO `" . DB_PREFIX . "proposal` (`customer`, `project_name`, `paymenttype`, `currency`, `date`, `expiry`, `items`, `total`, `note`, `tc`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", array( (int)$data['customer'], $this->model->escape($data['project_name']), $this->model->escape($data['paymenttype']), $data['currency'], $data['date'], $data['expiry'], $data['item'], $data['total'], $data['note'], $data['tc']));
		if ($query->num_rows > 0) {
			return $this->model->last_id();
		} else {
			return false;
		}
	}

	public function createInvoice($data)
	{
		$query = $this->model->query("INSERT INTO `" . DB_PREFIX . "invoice` (`customer`, `currency`, `duedate`, `paiddate`, `paymenttype`, `items`, `subtotal`, `tax`, `discount`, `discount_type`, `discount_value`, `amount`, `paid`, `due`, `note`, `tc`, `status`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", array( (int)$data['customer'], (int)$data['currency'], $this->model->escape($data['duedate']), $this->model->escape($data['paiddate']), (int)$data['paymenttype'], $data['items'], $data['subtotal'], $data['tax'], $data['discount'], $data['discounttype'], $data['discount_value'], $data['amount'], $data['paid'], $data['due'], $data['note'], $data['tc'], $data['status']));
		
		if ($query->num_rows > 0) {
			$id = $this->model->last_id();
			$this->model->query("UPDATE `" . DB_PREFIX . "proposal` SET `invoice_id` = ? WHERE `id` = ?", array((int)$id, (int)$data['id']));
			return $id;
		} else {
			return false;
		}
	}

	public function updateQuote($data)
	{
		$query = $this->model->query("UPDATE `" . DB_PREFIX . "proposal` SET `customer` = ?, `project_name` = ?, `paymenttype` = ?, `currency` = ?, `date` = ?, `expiry` = ?, `items` = ?, `total` = ?, `note` = ?, `tc` = ? WHERE `id` = ?", array((int)$data['customer'], $this->model->escape($data['project_name']), $this->model->escape($data['paymenttype']), $data['currency'], $data['date'], $data['expiry'], $data['item'], $data['total'], $data['note'], $data['tc'], (int)$data['id']));
		if ($query->num_rows > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function getTemplate($name)
	{
		$query = $this->model->query("SELECT * FROM `" . DB_PREFIX . "template` WHERE `template` = ? LIMIT 1", array($name));
		return $query->row;
	}

	public function deleteQuote($id)
	{
		$query = $this->model->query("DELETE FROM `" . DB_PREFIX . "proposal` WHERE `id` = ?", array((int)$id ));
		if ($query->num_rows > 0) {
			return true;
		} else {
			return false;
		}
	}
}