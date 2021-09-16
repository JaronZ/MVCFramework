<?php
class Core {
	protected $controller = DEFAULT_CONTROLLER;
	protected $method = DEFAULT_METHOD;
	protected $params = [];

	protected static function controllerName(string $name){
		return ucwords($name)."Controller";
	}

	protected static function controllerPath(string $contollerName){
		return APP_ROOT."/controllers/".$contollerName.".php";
	}

	public function __construct(){
		$url = $this->getURL();

		// Check if the contoller exist
		if(isset($url[0]) && file_exists(Core::controllerPath(Core::controllerName($url[0])))){
			$this->controller = array_shift($url);
		}

		// Make a new controller object
		$controller = Core::controllerName($this->controller);
		require_once(Core::controllerPath($controller));
		$this->controller = new $controller;

		// Set method of controller
		if(isset($url[0]) && method_exists($this->controller, $url[0])){
			$this->method = array_shift($url);
		}

		// Set parameters
		$this->params = $url;

		call_user_func_array([$this->controller, $this->method], $this->params);
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