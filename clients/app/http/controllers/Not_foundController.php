<?php

/**
* Not_found Controller
*/
class Not_foundController extends Controller
{
	static function show($error) {
		$notFound = new Not_foundController();
		$notFound->not_found($error);
	}

	protected function not_found($error)
	{
		$this->commons = new CommonsController();
		/*Get SUer name and role*/
		$data = $this->commons->getUser();
		if ($error === '403') {
			$this->view->render('not_found/403.tpl', $data );
		}
		else {
			$this->view->render('not_found/404.tpl', $data );
		}
	}
}