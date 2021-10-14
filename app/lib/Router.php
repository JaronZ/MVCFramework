<?php
class Router {
	private static array $routes = [
		"GET" => [],
		"POST" => [],
		"PUT" => [],
		"DELETE" => []
	];

	/**
	 * @param array|callable|null $action
	 */
	public static final function default($action = null) {
		if(!$action) return [
			"action" => @Router::$routes["default"] ?? null,
			"params" => []
		];
		Router::$routes["default"] = $action;
	}

	public static final function getRoute(array $url, string $method) {
		$routes = Router::$routes[$method];
		$lastRoute = "/";
		$setParams = false;
		$params = [];
		foreach($url as $endpoint) {
			if(!$setParams) {
				$routes = array_filter($routes, function($route) use($endpoint, $lastRoute) {
					return strpos($route, $lastRoute.$endpoint) === 0;
				}, ARRAY_FILTER_USE_KEY);
				$lastRoute .= $endpoint."/";
				if(count($routes) == 0) return null;
				if(count($routes) == 1 && isset($routes[$lastRoute])) $setParams = true;
				continue;
			}
			$params[] = $endpoint;
		}
		return [
			"action" => $routes[$lastRoute],
			"params" => $params
		];
	}

	/**
	 * @param string $route
	 * @param array|callable $action
	 */
	public static final function get(string $route, $action) {
		Router::$routes["GET"][$route] = $action;
	}

	/**
	 * @param string $route
	 * @param array|callable $action
	 */
	public static final function post(string $route, $action) {
		Router::$routes["POST"][$route] = $action;
	}

	/**
	 * @param string $route
	 * @param array|callable $action
	 */
	public static final function put(string $route, $action) {
		Router::$routes["PUT"][$route] = $action;
	}

	/**
	 * @param string $route
	 * @param array|callable $action
	 */
	public static final function delete(string $route, $action) {
		Router::$routes["DELETE"][$route] = $action;
	}
}