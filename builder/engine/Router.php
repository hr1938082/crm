<?php

/**
* Router
*/
class Router
{
	protected $routes = [
	'GET' => [],
	'POST' => []
	];

	public static function load($file)
	{		
		$router = new static;

		require $file;

		return $router;
	}

	public function get($uri, $controller)
	{
		$this->routes['GET'][$uri] = $controller;
	}

	public function post($uri, $controller)
	{	
		
		$this->routes['POST'][$uri] = $controller;
	}

	public function route($uri, $method)
	{
		if (array_key_exists($uri, $this->routes[$method])) {
			$route = explode('@', $this->routes[$method][$uri]);
			$route_array = array(
				'controller' => $route[0],
				'method' => $route[1]
				);
			$this->dispatch($route_array);
		} else {
			Not_foundController::show('404');
		}
	}

	protected function dispatch($route)
	{
		if (class_exists($route['controller'])) {
			$controller = new $route['controller']();
			if (method_exists($controller, $route['method'])) {
				$controller->{$route['method']}();
			} else {
				Not_foundController::show('404');
			}
		} else {
			Not_foundController::show('404');
		}
	}
}