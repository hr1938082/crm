<?php
require_once 'libs/Controller.php';
/**
* Error Controller
*/
class ErrorController extends Controller
{
    public function index($error)
	{
        $this->view->error = $error;
		$this->view->render('view/error/error.tpl');
	}
}