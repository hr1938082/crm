<?php
/*Set DateTimeZone to UTC*/
if (!ini_get('date.timezone')) {
	date_default_timezone_set('UTC');
}

if (!isset($_SERVER['DOCUMENT_ROOT'])) {
	if (isset($_SERVER['SCRIPT_FILENAME'])) {
		$_SERVER['DOCUMENT_ROOT'] = str_replace('\\', '/', substr($_SERVER['SCRIPT_FILENAME'], 0, 0 - strlen($_SERVER['PHP_SELF'])));
	}
}

if (!isset($_SERVER['DOCUMENT_ROOT'])) {
	if (isset($_SERVER['PATH_TRANSLATED'])) {
		$_SERVER['DOCUMENT_ROOT'] = str_replace('\\', '/', substr(str_replace('\\\\', '\\', $_SERVER['PATH_TRANSLATED']), 0, 0 - strlen($_SERVER['PHP_SELF'])));
	}
}

if (!isset($_SERVER['REQUEST_URI'])) {
	$_SERVER['REQUEST_URI'] = substr($_SERVER['PHP_SELF'], 1);

	if (isset($_SERVER['QUERY_STRING'])) {
		$_SERVER['REQUEST_URI'] .= '?' . $_SERVER['QUERY_STRING'];
	}
}

if (!isset($_SERVER['HTTP_HOST'])) {
	$_SERVER['HTTP_HOST'] = getenv('HTTP_HOST');
}

// Check if SSL
if ((isset($_SERVER['HTTPS']) && (($_SERVER['HTTPS'] == 'on') || ($_SERVER['HTTPS'] == '1'))) || $_SERVER['SERVER_PORT'] == 443) {
	$_SERVER['HTTPS'] = true;
} elseif (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https' || !empty($_SERVER['HTTP_X_FORWARDED_SSL']) && $_SERVER['HTTP_X_FORWARDED_SSL'] == 'on') {
	$_SERVER['HTTPS'] = true;
} else {
	$_SERVER['HTTPS'] = false;
}


spl_autoload_register(function($class){
	$builderPath = DIR_BUILDER;
	$appPath = DIR_APP;
	if(file_exists($builderPath.'engine/'.$class.'.php')){
		require_once $builderPath.'engine/'.$class.'.php';		
	} elseif(file_exists($builderPath.'libs/'.$class.'.php')){
		require_once $builderPath.'libs/'.$class.'.php';		
	} elseif(file_exists($appPath.'http/controllers/'.$class.'.php')){
		require_once $appPath.'http/controllers/'.$class.'.php';		
	} elseif(file_exists($appPath.'http/models/'.$class.'.php')){
		require_once $appPath.'http/models/'.$class.'.php';		
	}
});
spl_autoload_extensions('.php');

$registry = Registry::getInstance();
$registry->set('database', new Database);
$registry->set('url', new Url);
$session = new Session();
$session->start();
$registry->set('session', $session);

/**
* Check if user is logged in or not
* If logged in then get user basic info from DB
**/
$common = new Common();
if (!$common->isLoggedIn() && Request::uri() != 'login' && Request::uri() != 'register' && Request::uri() != 'forgot' && Request::uri() != 'reset') {
	header('location: index.php?route=login');
	exit();
}
Router::load(DIR_BUILDER. 'routes.php')
->route(Request::uri(), Request::method());