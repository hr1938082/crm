<?php
session_start();
// Error Reporting
error_reporting(E_ALL);

// Check Version
if (version_compare(phpversion(), '5.4.0', '<') == true) {
	exit('PHP5.4+ Required');
}

// Check if SSL
if ((isset($_SERVER['HTTPS']) && (($_SERVER['HTTPS'] == 'on') || ($_SERVER['HTTPS'] == '1'))) || $_SERVER['SERVER_PORT'] == 443) {
	$protocol = 'https://';
} elseif (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https' || !empty($_SERVER['HTTP_X_FORWARDED_SSL']) && $_SERVER['HTTP_X_FORWARDED_SSL'] == 'on') {
	$protocol = 'https://';
} else {
	$protocol = 'http://';
}

define('HTTP_SERVER', $protocol . $_SERVER['HTTP_HOST'] . rtrim(dirname($_SERVER['SCRIPT_NAME']), '/.\\') . '/');
define('HTTP_KLINIKAL', $protocol . $_SERVER['HTTP_HOST'] . rtrim(rtrim(dirname($_SERVER['SCRIPT_NAME']), 'install'), '/.\\') . '/');
define('HTTP_KLINIKAL_ADMIN', HTTP_KLINIKAL. 'admin/');
define('HTTP_CLIENTS', HTTP_KLINIKAL. 'clients/');

define('DIR_APPLICATION', str_replace('\\', '/', realpath(dirname(__FILE__))) . '/');
define('APPLICATION', str_replace('\\', '/', realpath(DIR_APPLICATION . '../')) . '/');
define('CLIENTS', str_replace('\\', '/', realpath(dirname(__FILE__) . '/../')) . '/clients/');
define('INSTALL', str_replace('\\', '/', realpath(dirname(__FILE__) . '/../')) . '/install/');
define('BUILDER', str_replace('\\', '/', realpath(dirname(__FILE__) . '/../')) . '/builder/');
define('APP', str_replace('\\', '/', realpath(dirname(__FILE__) . '/../')) . '/app/');
define('CLIENTS_BUILDER', str_replace('\\', '/', realpath(dirname(__FILE__) . '/../')) . '/clients/builder/');
define('CLIENTS_APP', str_replace('\\', '/', realpath(dirname(__FILE__) . '/../')) . '/clients/app/');

/*Configuration file path*/
$config_primary = APPLICATION.'config/config.php';
$config_seconadary = APPLICATION.'clients/config/config.php';

/*Check configuration file wraitable or not*/
if(is_writable($config_primary) && is_writable($config_seconadary) ) {
	require $config_primary;
}
else {
	exit('Error: Config files are not writable!');
}

/*Check database file(.sql file) exists or not*/ 
$sql = INSTALL.'libs/client_manager.sql';
if(!file_exists($sql)) {
	exit('Error: Database office_manager.sql file does not exist!');
}

require 'libs/Router.php';