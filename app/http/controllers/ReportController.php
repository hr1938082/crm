<?php

/**
* LeadController
*/
class ReportController extends Controller
{
	private $reportModel;
	function __construct()
	{
		parent::__construct();
		$this->commons = new CommonsController();
		/*Intilize User model*/
		$this->reportModel = new Report();
	}

	public function incomeReport()
	{
		$this->commons->isAdmin();
		
		/*Get User name and role*/
		$data = $this->commons->getUser();

		/*Load Language File*/
		require DIR_BUILDER.'language/'.$data['info']['language'].'/common.php';
		$data['lang']['common'] = $lang;

		$data['income'] = $this->reportModel->getIncomeReport();
		$data['lastweekincome'] = $this->reportModel->getLastWeekIncome();
		$data['lastmonthincome'] = $this->reportModel->getLastMonthIncome();
		$data['lastyearincome'] = $this->reportModel->getLastYearIncome();
		$data['tax'] = $this->reportModel->getTaxReport();
		$data['lastweektax'] = $this->reportModel->getLastWeekTax();
		$data['lastmonthtax'] = $this->reportModel->getLastMonthTax();
		$data['lastyeartax'] = $this->reportModel->getLastYearTax();

		$data['expenses'] = $this->reportModel->getExpenseReport();
		$data['lastweekexpenses'] = $this->reportModel->getLastWeekExpense();
		$data['lastmonthexpenses'] = $this->reportModel->getLastMonthExpense();
		$data['lastyearexpenses'] = $this->reportModel->getLastYearExpense();
		
		/* Set page title */
		$data['page_title'] = 'Income';

		function currencyConverter ($from_Currency, $to_Currency, $amount) {
			$from_Currency = urlencode(strtoupper($from_Currency));
			$to_Currency = urlencode(strtoupper($to_Currency));
			$url = file_get_contents('http://free.currencyconverterapi.com/api/v3/convert?q=' . $from_Currency . '_' . $to_Currency . '&compact=ultra');
			$json = json_decode($url, true);
			$rate = implode(" ",$json);
			$total = $rate * $amount;
			return $total;
		}

		//echo currencyConverter("INR", "USD", 1000);
		
		/*Render User list view*/
		$this->view->render('report/report_income.tpl', $data);
	}
}