<?php

/**
* PaymentController
*/
class PaymentController extends Controller
{
	private $user_id;
	private $commons;
	function __construct() 
	{
		parent::__construct();
		/**
		* Check user is logged in or not
		* If logged in than get user_id from session varible
		**/
		$common = new Common();
		$this->commons = new CommonsController();
		if ($common->isLoggedIn()) {
			$this->user_id = $this->session->data['user_id'];
		} else {
			/**
			* If user is not logged in
			* Then redirect to login page
			**/
			$this->url->redirect('login');
		}
	}
	public function makePayment()
	{
		$id = (int)$this->url->get('invoice');
		if (empty($id) || !is_int($id)) {
			$this->url->redirect('invoices');
		}

		$data = $this->commons->getUser();
		
		$data['cancel'] = URL_CLIENTS.DIR_ROUTE.'cancel';
		$data['success'] = URL_CLIENTS.DIR_ROUTE.'successpayment';

		$paymentModel = new Payment();
		$paymentData = $paymentModel->getPaymentData();

		if ($paymentData['status'] == "0") {
			echo "Online Payment Gateway is disabled.";
			exit();
		}

		$data['token'] = $this->token_generator(64);
		$this->session->data['payment_token'] = $data['token'];

		if (!empty($paymentData['username'])) {
			$data['paypalID'] = $paymentData['username'];
		} else {
			echo "Online Payment Gateway is disabled.";
			exit();
		}

		if ($paymentData['mode'] == "1") {
			$data['paypalURL'] = 'https://www.paypal.com/cgi-bin/webscr';
		} else {
			$data['paypalURL'] = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
		}

		$data['result'] = $paymentModel->getInvoiceData($id);
		
		if ($data['result']['due'] <= "0") {
			$this->url->redirect('invoice&id='.$id);
		}

		/*Load Language File*/
		require DIR_BUILDER.'language/'.$data['info']['language'].'/common.php';
		$data['lang']['common'] = $lang;
		require DIR_BUILDER.'language/'.$data['info']['language'].'/payments.php';
		$data['lang']['payments'] = $payments;

		/*Render User list view*/
		$this->view->render('payment/make_payment.tpl', $data);
	}

	public function cancelPayment()
	{
		$data = $this->commons->getUser();

		/*Load Language File*/
		require DIR_BUILDER.'language/'.$data['info']['language'].'/common.php';
		$data['lang']['common'] = $lang;
		require DIR_BUILDER.'language/'.$data['info']['language'].'/payments.php';
		$data['lang']['payments'] = $payments;
		
		/*Render User list view*/
		$this->view->render('payment/cancel.tpl', $data);
	}

	public function successPayment()
	{
		$data = $this->url->post;
		if ( isset($this->session->data['payment_token']) && $data['custom'] != $this->session->data['payment_token']) {
			$this->url->redirect('cancel');
		}

		unset($this->session->data['payment_token']);

		$paymentModel = new Payment();
		$checkTxnId = $paymentModel->checkTxnId($data['txn_id']);

		$paymentData = $paymentModel->getPaymentData();

		if (!empty($checkTxnId)) {
			$this->url->redirect('cancel');
		}

		if ($data['business'] != $paymentData['username']) {
			$this->url->redirect('cancel');	
		}

		if ($data['payment_status'] != "Completed") {
			$this->url->redirect('cancel');	
		}

		$data['payment_date'] = date_format(date_create($data['payment_date']), 'Y-m-d H:i:s');

		$invoiceData = $paymentModel->getInvoiceData($data['item_number']);

		$result = $paymentModel->createPayment($data);
		
		$invoiceData['due'] = (int)$invoiceData['due'] - $data['payment_gross'];
		$invoiceData['paid'] = (int)$invoiceData['paid'] + $data['payment_gross'];
		$invoiceData['id'] = $data['item_number'];
		if ($invoiceData['due'] > .9) {
			$invoiceData['status'] = "Partially Paid";
		} else {
			$invoiceData['status'] = "Paid";
		}
		
		$result = $paymentModel->updateInvoiceAmount($invoiceData);

		$info = $paymentModel->getOrganisation();

		$template = $paymentModel->getTemplate('paymentconfirmation');
		$data['id'] = str_pad($data['item_number'], 4, '0', STR_PAD_LEFT);
		$site_link = '<a href="'.URL_CLIENTS.DIR_ROUTE.'invoice/view&id='.$data['item_number'].'">Click Here</a>';
		$message = $template['message'];

		$message = str_replace('{company}', $invoiceData['company'], $message);
		$message = str_replace('{id}', 'INV-'.$data['id'], $message);
		$message = str_replace('{txn_id}', $data['txn_id'], $message);
		$message = str_replace('{paid_date}', $data['payment_date'], $message);
		$message = str_replace('{paid_amount}', $data['mc_currency'].' '.$data['payment_gross'], $message);
		$message = str_replace('{business_name}', $info['name'], $message);
		$message = str_replace('{inv_url}', $site_link, $message);

		$mailer = new Mailer();
		$mailer->mail->setFrom($info['email'], $info['name']);
		$mailer->mail->addAddress($invoiceData['email'], $invoiceData['company']);
		$mailer->mail->isHTML(true);
		$mailer->mail->Subject = $template['subject'];
		$mailer->mail->Body = html_entity_decode($message);
		$mailer->mail->AltBody = 'Hello '.$invoiceData['firstname'].'.
		Your Invoice has been Paid on '.$data['payment_date'].'.
		Your Invoice ID : '.$data['item_number'].'';
		$mailer->sendMail();

		$this->session->data['txn_id'] = $data['txn_id'];
		$this->url->redirect('success');
	}

	public function success()
	{
		$data = $this->commons->getUser();

		if (!isset($this->session->data['txn_id'])) {
			$this->url->redirect('dashboard');
		}
		$data['txn_id'] = $this->session->data['txn_id'];
		unset($this->session->data['txn_id']);

		/*Load Language File*/
		require DIR_BUILDER.'language/'.$data['info']['language'].'/common.php';
		$data['lang']['common'] = $lang;
		require DIR_BUILDER.'language/'.$data['info']['language'].'/payments.php';
		$data['lang']['payments'] = $payments;

		/*Render User list view*/
		$this->view->render('payment/success.tpl', $data);
	}

	private function token_generator( $length = 64 ) {
		$token = "";
		$charArray = str_split("ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz");
		for($i = 0; $i < $length; $i++){
			$randItem = array_rand($charArray);
			$token .= "".$charArray[$randItem];
		}
		return $token;
	}

}