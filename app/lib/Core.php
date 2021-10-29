<?php
class Core {
	public function __construct() {
		$route = isset($_GET["url"]) ?
			Router::getRoute($_GET["url"], $_SERVER["REQUEST_METHOD"]) :
			Router::default($_SERVER["REQUEST_METHOD"]);
		if($route == null) {
			echo "Unknown route";
			return;
		}
		$action = $route["action"];
		if(is_array($action)){
			$controller = /* "App\\Controllers\\". */$action[0];
			$action[0] = new $controller;
		}
		call_user_func_array($action, $route["params"]);
	}
}