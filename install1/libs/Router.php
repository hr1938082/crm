<?php

/*Check application requirments*/
function check_requirements() {
	$error = null;
	if (phpversion() < '5.4') {
		$error = 'Error: You need to use PHP5.5 or above for Client Manager to work!';
	}

	if (!ini_get('file_uploads')) {
		$error = 'Error: file_uploads needs to be enabled!';
	}

	if (ini_get('session.auto_start')) {
		$error = 'Warning: Client Manager will not work with session.auto_start enabled!';
	}

	if (!extension_loaded('mysqli')) {
		$error = 'Error: MySQLi extension needs to be loaded for Client Manager to work!';
	}

	if (!extension_loaded('gd')) {
		$error = 'Warning: GD extension needs to be loaded for Client Manager to work!';
	}

	if (!extension_loaded('zlib')) {
		$error = 'Warning: ZLIB extension needs to be loaded for Client Manager to work!';
	}

	return array($error === null, $error);
}

/*Controller call for view*/
function view($view) {
    $check = check_requirements();
	if ($check[0]) {
        require 'controller/StepController.php';
        $step = new StepController();
        $step->index($view);
	} else {
        require 'controller/ErrorController.php';
		$error = new ErrorController();
        $error->index($check[1]);
	}
}

/*Controller call for action*/
function install() {
        require 'controller/StepController.php';
    $step = new StepController();
    $step->indexAction();
}

/*Get request or url*/
$step = 1;
if(isset($_GET['route'])) {
    $token = explode('/', rtrim($_GET['route'], '/'));
    if(!empty($token[1])) {
        $step = $token[1];
    }
    else {
       $step = 1;
    }
}

/*Route to function*/
switch ($step) {
    case "1": 
            view('step_1'); break;
    case "2": 
            view('step_2'); break;
    case "3": 
            view('step_3'); break;
    case "action": 
            install(); break;
    default:
	       view('step_1'); break;
}