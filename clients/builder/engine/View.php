<?php

/**
* 
*/
class View
{
	public function render($viewscript, $vars = array()) 
	{
		extract($vars);
		if (!empty($header)) { extract($header); }
		include (DIR_APP.'views/'.$viewscript.'.php');
	}
}