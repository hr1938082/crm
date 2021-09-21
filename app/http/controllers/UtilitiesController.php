<?php

/**
* UtilitiesController
*/
class UtilitiesController extends Controller
{
	private $utilitiesModel;
	function __construct()
	{
		parent::__construct();
		$this->commons = new CommonsController();
		/*Intilize User model*/
		$this->utilitiesModel = new Utilities();
	}

	public function emailLog()
	{
		$this->commons->isAdmin();

		/*Get User name and role*/
		$data = $this->commons->getUser();

		$data['result'] = $this->utilitiesModel->getEmailLogs();

		/*Load Language File*/
		require DIR_BUILDER.'language/'.$data['info']['language'].'/common.php';
		$data['lang']['common'] = $lang;
		require DIR_BUILDER.'language/'.$data['info']['language'].'/utilities.php';
		$data['lang']['utilities'] = $utilities;

		/* Set page title */
		$data['page_title'] = $data['lang']['utilities']['text_email_log'];
		
		/*Render User list view*/
		$this->view->render('utilities/email_log.tpl', $data);
	}

	public function cronLog()
	{
		$this->commons->isAdmin();

		/*Get User name and role*/
		$data = $this->commons->getUser();

		$data['result'] = $this->utilitiesModel->getCronLogs();

		/*Load Language File*/
		require DIR_BUILDER.'language/'.$data['info']['language'].'/common.php';
		$data['lang']['common'] = $lang;
		require DIR_BUILDER.'language/'.$data['info']['language'].'/utilities.php';
		$data['lang']['utilities'] = $utilities;

		/* Set page title */
		$data['page_title'] = $data['lang']['utilities']['text_cron_log'];
		
		/*Render User list view*/
		$this->view->render('utilities/cron_log.tpl', $data);
	}
}