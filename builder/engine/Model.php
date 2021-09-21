<?php

/**
* Model
*/
class Model
{
	public $model;

	function __construct()
	{
		$this->model = Registry::getInstance()->get('database');
		$this->model->connect(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
	}

	public function model($link) 
	{
		require_once(DIR_APP.'models/'.$link.'.php');
	}
}