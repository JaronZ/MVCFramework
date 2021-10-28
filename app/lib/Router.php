<?php
class Router {
	private static array $routes = [];

	/**
	 * @param array|callable|null $action
	 */
	public static final function default($action = null) {
		if(!$action) return [
			"action" => Router::$routes["default"] ?? null,
			"params" => []
		];
		Router::$routes["default"] = $action;
	}

	public static final function getRoute(string $url, string $method) {
		if(!isset(Router::$routes[$method])) return null;
		$routes = array_filter(Router::$routes[$method], function($route) use ($url) {
			return strpos($url, trim($route, "/")) === 0;
		}, ARRAY_FILTER_USE_KEY);
		if(count($routes) === 0) return null;
		$route = array_keys($routes)[0];
		$params = Router::getParams($url, $route);
		return [
			"action" => $routes[$route],
			"params" => $params
		];
	}

	/**
	 * @param string $route
	 * @param array|callable $action
	 */
	public static final function get(string $route, $action) {
		Router::addRoute("GET", $route, $action);
	}

	/**
	 * @param string $route
	 * @param array|callable $action
	 */
	public static final function post(string $route, $action) {
		Router::addRoute("POST", $route, $action);
	}

	/**
	 * @param string $route
	 * @param array|callable $action
	 */
	public static final function put(string $route, $action) {
		Router::addRoute("PUT", $route, $action);
	}

	/**
	 * @param string $route
	 * @param array|callable $action
	 */
	public static final function delete(string $route, $action) {
		Router::addRoute("DELETE", $route, $action);
	}

	private static final function addRoute(string $method, string $route, $action) {
		// Add method to routes if it doesn't exist
		Router::$routes[$method] ??= [];
		Router::$routes[$method][$route] = $action;
	}

	private static function getParams(string $url, string $route) {
		$params = substr($url, strlen(ltrim($route, "/")));
		if($params === "") return [];
		// Remove the slash at the end of the params
		// Then sanitize it, so characters like @ can not be used
		// Then break it into an array at every forward slash
		$params = explode("/",
			filter_var(
				rtrim($params, "/"),
			FILTER_SANITIZE_URL)
		);
		return $params;
	}
}