<?php

/**
* 
*/
class Controller
{
	/* Url class varible to calling Url class method */
	public $url;
	function __construct()
	{
		$this->session = Registry::getInstance()->get('session');
		/* Intilize View Class */
		$this->url = Registry::getInstance()->get('url');
		/* Intilize View Class */
		$this->view = new View();
	}
}