<?php
class Route {
	/**
	 * The route string of this route
	 */
	private string $route;
	/**
	 * The action of this route
	 * @var array|callable
	 */
	private $action;
	/**
	 * The parameters of this route
	 * @var string[]
	 */
	public array $params = [];

	/**
	 * @param string $route The route string of this route
	 * @param array|callable $action The action of this route
	 */
	public function __construct(string $route, $action) {
		$this->route = $route;
		$this->action = $action;
	}

	/**
	 * Get the route string of this route
	 */
	public function getRoute() {
		return $this->route;
	}

	/**
	 * Get the action of this route
	 */
	public function getAction() {
		return $this->action;
	}
}