<?php
namespace Common\Router;

use Zend\Router\Http\Literal;
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
	 * @var bool
	 */
	private $addToSitemap = false;

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
	 * @param bool $addToSitemap
	 * @return HttpRouteCreator
	 */
	public function setAddToSitemap(bool $addToSitemap): HttpRouteCreator
	{
		$this->addToSitemap = $addToSitemap;

		return $this;
	}

	/**
	 * @return array
	 */
	public function getConfig()
	{
		return [
			'type'			=> $this->constraints ? Segment::class : Literal::class,
			'may_terminate'	=> $this->mayTerminate,
			'options'	=> [
				'route'		=> $this->route,
				'defaults'	=> [
					'controller'	=> $this->action,
					'action'		=> 'execute',
				],
				'constraints'		=> $this->constraints,
				'add_to_sitemap'	=> $this->addToSitemap,
			],
			'child_routes'	=> $this->childRoutes
		];
	}
}