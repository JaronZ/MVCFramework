<?php
class Core {
	public function __construct() {
		$route = Router::getRoute($_GET["url"] ?? "/", $_SERVER["REQUEST_METHOD"]);
		if($route == null) {
			echo "Unknown route";
			return;
		}
		$action = $route->getAction();
		if(is_array($action)) $action[0] = new $action[0];
		call_user_func_array($action, $route->params);
	}
}