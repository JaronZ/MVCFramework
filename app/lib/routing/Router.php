<?php
class Router {
	/**
	 * @var Route[][]
	 */
	private static array $routes = [];

	/**
	 * Get or set the default route for the specified method
	 * @param string $method The method to get routes from or add routes to
	 * @param array|callable|null $action The action to set as default
	 */
	public static final function default(string $method, $action = null) {
		if(!$action) return Router::getRoute("/", $method);
		Router::addRoute($method, new Route("/", $action));
	}
	
	/**
	 * Get one of the routes of this router
	 * @param string $url The url to get the route from
	 * @param string $method The method to get the routes from
	 * @return Route|null The found route
	 */
	public static final function getRoute(string $url, string $method) {
		// Check if the router has any routes for the specified method
		if(!isset(Router::$routes[$method])) return null;
		// Get the routes that match the start of the url
		$routes = array_filter(Router::$routes[$method], function($route) use ($url) {
			if ($url === "/") return $route->getRoute() === $url;
			return strpos($url, trim($route->getRoute(), "/")) === 0;
		});
		if(count($routes) === 0) return null;
		$route = $routes[0];
		$route->params = Router::getParams($url, $route->getRoute());
		return $route;
	}

	/**
	 * Add a route to the GET method
	 * @param string $route The route to add
	 * @param array|callable $action The action to perform when this route is hit
	 */
	public static final function get(string $route, $action) {
		$route = new Route($route, $action);
		Router::addRoute("GET", $route);
		Router::addRoute("HEAD", $route);
	}

	/**
	 * Add a route to the POST method
	 * @param string $route The route to add
	 * @param array|callable $action The action to perform when this route is hit
	 */
	public static final function post(string $route, $action) {
		return Router::addRoute("POST", new Route($route, $action));
	}

	/**
	 * Add a route to the PUT method
	 * @param string $route The route to add
	 * @param array|callable $action The action to perform when this route is hit
	 */
	public static final function put(string $route, $action) {
		return Router::addRoute("PUT", new Route($route, $action));
	}

	/**
	 * Add a route to the DELETE method
	 * @param string $route The route to add
	 * @param array|callable $action The action to perform when this route is hit
	 */
	public static final function delete(string $route, $action) {
		return Router::addRoute("DELETE", new Route($route, $action));
	}

	/**
	 * Add a route to the PATCH method
	 * @param string $route The route to add
	 * @param array|callable $action The action to perform when this route is hit
	 */
	public static final function patch(string $route, $action) {
		return Router::addRoute("PATCH", new Route($route, $action));
	}

	/**
	 * Add a route to all methods
	 * @param string $route The route to add
	 * @param array|callable $action The action to perform when this route is hit
	 */
	public static final function any(string $route, $action) {
		$route = new Route($route, $action);
		Router::addRoute("GET", $route);
		Router::addRoute("POST", $route);
		Router::addRoute("PUT", $route);
		Router::addRoute("DELETE", $route);
		Router::addRoute("PATCH", $route);
	}

	/**
	 * Add a route to the routes of the specified method
	 * @param string $method The method to add a route to
	 * @param string $route The route to add
	 * @param array|callable $action The action to perform when this route is hit
	 * @return Route The created route
	 */
	private static final function addRoute(string $method, Route $route) {
		// Add method to routes if it doesn't exist
		Router::$routes[$method] ??= [];
		Router::$routes[$method][] = $route;
		return $route;
	}

	/**
	 * Get the parameters of a url
	 * @param string $url The url to get parameters from
	 * @param string $route The route to remove from the url
	 */
	private static function getParams(string $url, string $route) {
		// Remove the route from the url
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