<?php
class Core {
	public function __construct(){
		$url = $this->getURL();
		$route = count($url) == 0 ? Router::default() : Router::getRoute($url, $_SERVER["REQUEST_METHOD"]);
		if($route == null) {
			echo "Unknown route";
			return;
		}
		call_user_func_array($route["action"], $route["params"]);
	}

	public function getURL(){
		if(isset($_GET["url"])){
			// Get url and remove the slash at the end
			// Then sanitize the url, so characters like @ can not be used
			// Then break it into an array at every forward slash
			$url = explode("/",
				filter_var(
					rtrim($_GET["url"], "/"),
				FILTER_SANITIZE_URL)
			);

			return $url;
		}
		return [];
	}
}