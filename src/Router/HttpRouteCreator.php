<?php
namespace Common\Router;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Method;
use Zend\Router\Http\Segment;

class HttpRouteCreator
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
	 * @var bool
	 */
	private $mayTerminate = true;

	/**
	 * @var array
	 */
	private $constraints;

	/**
	 * @var array
	 */
	private $childRoutes;

	/**
	 * @var array
	 */
	private $methods = [];

	/**
	 * @return HttpRouteCreator
	 */
	public static function create()
	{
		return new self();
	}

	/**
	 * @param string $route
	 * @return HttpRouteCreator
	 */
	public function setRoute(string $route): HttpRouteCreator
	{
		$this->route = $route;

		return $this;
	}

	/**
	 * @param string $action
	 * @return HttpRouteCreator
	 */
	public function setAction(string $action): HttpRouteCreator
	{
		$this->action = $action;

		return $this;
	}

	/**
	 * @param bool $mayTerminate
	 * @return HttpRouteCreator
	 */
	public function setMayTerminate(bool $mayTerminate): HttpRouteCreator
	{
		$this->mayTerminate = $mayTerminate;

		return $this;
	}

	/**
	 * @param array $constraints
	 * @return HttpRouteCreator
	 */
	public function setConstraints(array $constraints): HttpRouteCreator
	{
		$this->constraints = $constraints;

		return $this;
	}

	/**
	 * @param array $childRoutes
	 * @return HttpRouteCreator
	 */
	public function setChildRoutes(array $childRoutes): HttpRouteCreator
	{
		$this->childRoutes = $childRoutes;

		return $this;
	}

	/**
	 * @param array $methods
	 * @return HttpRouteCreator
	 */
	public function setMethods(array $methods): HttpRouteCreator
	{
		$this->methods = $methods;

		return $this;
	}

	/**
	 * @return array
	 */
	public function getConfig()
	{
		$type = Literal::class;

		if ($this->constraints)
		{
			$type = Segment::class;
		}

		if ($this->methods)
		{
			$type = Method::class;
		}

		return [
			'type'			=> $type,
			'may_terminate'	=> $this->mayTerminate,
			'options'	=> [
				'route'		=> $this->route,
				'verb'		=> implode(',', $this->methods),
				'defaults'	=> [
					'controller'	=> $this->action,
					'action'		=> 'execute',
				],
				'constraints'		=> $this->constraints,
			],
			'child_routes'	=> $this->childRoutes
		];
	}
}