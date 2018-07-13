<?php
namespace Common\Router;

use Zend\Mvc\Console\Router\Simple;

class ConsoleRouteCreator
{
	/**
	 * @var string
	 */
	private $route;

	/**
	 * @var string
	 */
	private $action;

	/**
	 * @return ConsoleRouteCreator
	 */
	public static function create()
	{
		return new self();
	}

	/**
	 * @param string $route
	 * @return ConsoleRouteCreator
	 */
	public function setRoute($route)
	{
		$this->route = $route;

		return $this;
	}

	/**
	 * @param string $action
	 * @return ConsoleRouteCreator
	 */
	public function setAction($action)
	{
		$this->action = $action;

		return $this;
	}

	/**
	 * @return array
	 */
	public function getConfig()
	{
		return [
			'type'			=> Simple::class,
			'options'		=> [
				'route'			=> $this->route,
				'defaults'		=> [
					'controller'	=> $this->action,
					'action'		=> 'execute',
				],
			]
		];
	}
}