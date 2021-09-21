<?php

/**
* Dashboard Model
*/

class Dashboard extends Model
{
	public function getCurrency()
	{
		$query = $this->model->query("SELECT `id`, `name` FROM `" . DB_PREFIX . "currency`");
		return $query->rows;
	}

	public function getstatistics()
	{
		$query = $this->model->query("(SELECT count(*) AS `total` FROM `" . DB_PREFIX . "contacts`) UNION ALL (SELECT count(*) AS `total` FROM `" . DB_PREFIX . "projects`) UNION ALL (SELECT count(*) AS `total` FROM `" . DB_PREFIX . "invoice`) UNION ALL (SELECT count(*) AS `total` FROM `" . DB_PREFIX . "proposal`)");
		return $query->rows;
	}

	public function getInvoiceByStatus()
	{
		$query = $this->model->query("SELECT COUNT(id) AS value, `status` AS `label` FROM `" . DB_PREFIX . "invoice` GROUP BY `status`");
		return $query->rows;
	}

	public function getTicketByStatus()
	{
		$query = $this->model->query("SELECT COUNT(id) AS value, IF(`status` = 1, 'Closed', 'Open') AS `label` FROM `" . DB_PREFIX . "tickets` GROUP BY `status`");
		return $query->rows;
	}

	public function getRecentlyAdded()
	{
		$data = array();
		$contact = $this->model->query("SELECT `id`, concat(`salutation`, ' ', `firstname`, ' ', `lastname`) AS name, `company`, `date_of_joining` FROM `" . DB_PREFIX . "contacts` ORDER BY `date_of_joining` DESC LIMIT 5");
		$data['contacts'] = $contact->rows;

		$invoice = $this->model->query("SELECT i.id, c.company, i.amount, cr.abbr, i.date_of_joining FROM `" . DB_PREFIX . "invoice` AS i LEFT JOIN `" . DB_PREFIX . "contacts` AS c ON c.id = i.customer LEFT JOIN `" . DB_PREFIX . "currency` AS cr ON cr.id = i.currency ORDER BY i.date_of_joining DESC LIMIT 5");
		
		$data['invoices'] = $invoice->rows;

		$quotes = $this->model->query("SELECT p.id, p.project_name, c.company, p.date_of_joining FROM `" . DB_PREFIX . "proposal` AS p LEFT JOIN `" . DB_PREFIX . "contacts` AS c ON c.id = p.customer ORDER BY p.date_of_joining DESC LIMIT 5");
		$data['quotes'] = $quotes->rows;

		$expense = $this->model->query("SELECT e.id, e.purchase_by, e.purchase_amount, cr.abbr, e.date_of_joining FROM `" . DB_PREFIX . "expenses` AS e LEFT JOIN `" . DB_PREFIX . "currency` AS cr ON cr.id = e.currency ORDER BY e.date_of_joining DESC LIMIT 5");
		$data['expenses'] = $expense->rows;

		return $data;
	}

	public function getLatestContact($user = NULL)
	{
		if (!$user) {
			$query = $this->model->query("SELECT `id`, `firstname`, `lastname`, `company` FROM `" . DB_PREFIX . "contacts` ORDER BY `date_of_joining` DESC LIMIT 5");
		} else {
			$query = $this->model->query("SELECT `id`, `firstname`, `lastname`, `company` FROM `" . DB_PREFIX . "contacts` WHERE user_id = ? ORDER BY `date_of_joining` DESC LIMIT 5", array($user));
		}
		return $query->rows;
	}

	public function getLatestInvoice($user = NULL)
	{
		if (!$user) {
			$query = $this->model->query("SELECT i.id, c.company, cr.abbr, i.amount, i.status, i.date_of_joining FROM `" . DB_PREFIX . "invoice` AS i LEFT JOIN `" . DB_PREFIX . "contacts` AS c ON c.id = i.customer LEFT JOIN `" . DB_PREFIX . "currency` AS cr ON cr.id = i.currency ORDER BY i.date_of_joining DESC LIMIT 5");
		} else {
			$query = $this->model->query("SELECT i.id, c.company, cr.abbr, i.amount, i.status, i.date_of_joining FROM `" . DB_PREFIX . "invoice` AS i LEFT JOIN `" . DB_PREFIX . "contacts` AS c ON c.id = i.customer LEFT JOIN `" . DB_PREFIX . "currency` AS cr ON cr.id = i.currency WHERE c.user_id = ? ORDER BY i.date_of_joining DESC LIMIT 5", array($user));
		}
		return $query->rows;
	}

	public function getIncome()
	{
		$query = $this->model->query("SELECT SUM(amount) AS total, concat(MONTH(date_of_joining), '-', YEAR(date_of_joining)) AS `period`, MONTH(date_of_joining) AS `month`, YEAR(date_of_joining) AS `year` FROM `" . DB_PREFIX . "invoice` GROUP BY MONTH(date_of_joining) ORDER BY `year` ASC");
		return $query->rows;
	}

	public function getExpenses()
	{
		$query = $this->model->query("SELECT COUNT(e.id) AS value, et.name AS `label` FROM `" . DB_PREFIX . "expenses` AS e LEFT JOIN `" . DB_PREFIX . "expense_type` AS et ON et.id = e.expense_type GROUP BY et.name");
		return $query->rows;
	}

	public function getIncomeExpenses()
	{
		$query = $this->model->query("SELECT concat( YEAR(i.date_of_joining), '-',LPAD(MONTH(i.date_of_joining), 2, '0')) AS `period`, SUM(i.amount) AS income, SUM(e.purchase_amount) AS expense FROM `" . DB_PREFIX . "invoice` AS i LEFT JOIN `" . DB_PREFIX . "expenses` AS e ON MONTH(i.date_of_joining) = MONTH(e.date_of_joining) WHERE i.date_of_joining >= NOW() - INTERVAL 6 MONTH GROUP BY MONTH(i.date_of_joining) UNION 
			SELECT concat(YEAR(e.date_of_joining), '-', LPAD(MONTH(e.date_of_joining), 2, '0')) AS `period`, SUM(i.amount) AS income, SUM(e.purchase_amount) AS expense FROM `" . DB_PREFIX . "expenses` AS e LEFT JOIN `" . DB_PREFIX . "invoice` AS i ON MONTH(i.date_of_joining) = MONTH(e.date_of_joining) WHERE e.date_of_joining >= NOW() - INTERVAL 6 MONTH GROUP BY MONTH(e.date_of_joining)");
		return $query->rows;
	}

	/*public function getIncomeExpenses()
	{
		$query = $this->model->query("SELECT concat( LPAD(MONTH(i.date_of_joining), 2, '0'), '-',YEAR(i.date_of_joining)) AS `period`, SUM(i.amount) AS income, SUM(e.purchase_amount) AS expense FROM `" . DB_PREFIX . "invoice` AS i LEFT JOIN `" . DB_PREFIX . "expenses` AS e ON MONTH(i.date_of_joining) = MONTH(e.date_of_joining) WHERE i.date_of_joining >= NOW() - INTERVAL 6 MONTH GROUP BY MONTH(i.date_of_joining) UNION 
			SELECT concat(LPAD(MONTH(e.date_of_joining), 2, '0'), '-', YEAR(e.date_of_joining)) AS `period`, SUM(i.amount) AS income, SUM(e.purchase_amount) AS expense FROM `" . DB_PREFIX . "expenses` AS e LEFT JOIN `" . DB_PREFIX . "invoice` AS i ON MONTH(i.date_of_joining) = MONTH(e.date_of_joining) WHERE e.date_of_joining >= NOW() - INTERVAL 6 MONTH GROUP BY MONTH(e.date_of_joining)");
		return $query->rows;
	}*/

	public function getExpensesValue()
	{
		$query = $this->model->query("SELECT COUNT(e.id) AS value, et.name AS `label`, MONTH(e.date_of_joining) AS month FROM `" . DB_PREFIX . "expenses` AS e LEFT JOIN `" . DB_PREFIX . "expense_type` AS et ON et.id = e.expense_type GROUP BY et.name, MONTH(e.date_of_joining) ORDER BY e.date_of_joining");
		return $query->rows;
	}
}