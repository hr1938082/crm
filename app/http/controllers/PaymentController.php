<?php

/**
* PaymentController
*/
class PaymentController extends Controller
{
	private $paymentModel;
	function __construct()
	{
		parent::__construct();
		$this->commons = new CommonsController();
		/*Intilize User model*/
		$this->paymentModel = new Payment();
	}
	/**
	* Add Invoice Payment
	* This method will be called to add payment history
	**/
	public function invoicePayment()
	{
		/**
		* Check if from is submitted or not 
		**/
		if (!isset($_POST['submit'])) {
			$this->url->redirect('invoices');
			exit();
		}
		/**
		* Validate form data
		* If some data is missing or data does not match pattern
		* Return to info view 
		**/
		if ($validate_field = $this->validateField()) {
			$this->session->data['message'] = array('alert' => 'error', 'value' => 'Please enter valid '.implode(", ",$validate_field).'!');
			$this->url->redirect('items');
		}

		$data = $this->url->post('payment');
		$data['date'] = date_format(date_create($data['date']), 'Y-m-d');
		
		$result = $this->paymentModel->addInvoicePayment($data);
		$this->paymentModel->invoiceTotal($data);

		$this->session->data['message'] = array('alert' => 'success', 'value' => 'Payment added successfully');
		$this->url->redirect('invoice/view&id='.$data['invoice']);
	}

	protected function validateField()
	{
		$error = [];
		$error_flag = false;

		if ($this->commons->validateNumeric($this->url->post('payment')['method'])) {
			$error_flag = true;
			$error['method'] = 'Payment Method';
		}

		if ($error_flag) {
			return $error;
		} else {
			return false;
		}
	}
}