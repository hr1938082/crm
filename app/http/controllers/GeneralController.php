<?php

/**
* GeneralController
*/
class GeneralController extends Controller
{
	/**
	* Private General model variable
	* This will be used for calling General model's function
	**/
	private $generalModel;
	function __construct()
	{
		parent::__construct();
		$this->commons = new CommonsController();
		/* Intilize Blog model */
		$this->generalModel = new General();
	}
	public function index()
	{
		/*Get User name and role*/
		$data['user'] = $this->commons->getUser();
		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}
		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);
		$data['action'] = URL_ADMIN.DIR_ROUTE.'general/action';
		/*Render Blog view*/
		$this->view->render('setting/general.tpl', $data);
	}

	public function indexAction()
	{
		
	}
}