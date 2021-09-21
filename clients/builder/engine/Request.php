<?php

/**
* 
*/
class Request
{
	public static function uri()
	{
		if (isset($_GET['route'])) {
			return trim($_GET['route'], '/');
		} else {
			return 'login';
		}
	}

	public static function method()
	{
		return $_SERVER['REQUEST_METHOD'];
	}
}