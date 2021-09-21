<?php
/**
* View
*/
class View 
{
	public function render($viewscript) 
	{
		require_once($viewscript);
	}
}