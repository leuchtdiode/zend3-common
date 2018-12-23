<?php
namespace CommonTest\Router;

use Common\Router\HttpRouteCreator;
use CommonTest\Base;

class HttpRouteCreatorTest extends Base
{
	public function test_route_creation()
	{
		$this->assertEquals(
			[
				'type'          => 'Zend\\Router\\Http\\Literal',
				'may_terminate' => true,
				'options'       =>
					[
						'route'       => '/user',
						'verb'        => '',
						'defaults'    =>
							[
								'controller' => 'AnyNamespace\\User\\GetList',
								'action'     => 'execute',
							],
						'constraints' => null,
					],
				'child_routes'  =>
					[
						'single-item' =>
							[
								'type'          => 'Zend\\Router\\Http\\Segment',
								'may_terminate' => true,
								'options'       =>
									[
										'route'       => '/:id',
										'verb'        => '',
										'defaults'    =>
											[
												'controller' => 'AnyNamespace\\User\\Get',
												'action'     => 'execute',
											],
										'constraints' =>
											[
												'id' => '.{36}',
											],
									],
								'child_routes'  =>
									[
										'remove' =>
											[
												'type'          => 'Zend\\Router\\Http\\Method',
												'may_terminate' => true,
												'options'       =>
													[
														'route'       => null,
														'verb'        => 'DELETE',
														'defaults'    =>
															[
																'controller' => 'AnyNamespace\\User\\Remove',
																'action'     => 'execute',
															],
														'constraints' => null,
													],
												'child_routes'  => null,
											],
									],
							],
					],
			],
			HttpRouteCreator::create()
				->setRoute('/user')
				->setAction('AnyNamespace\User\GetList')
				->setChildRoutes(
					[
						'single-item' => HttpRouteCreator::create()
							->setAction('AnyNamespace\User\Get')
							->setRoute('/:id')
							->setConstraints(
								[
									'id' => '.{36}',
								]
							)
							->setChildRoutes(
								[
									'remove' => HttpRouteCreator::create()
										->setAction('AnyNamespace\User\Remove')
										->setMethods([ 'DELETE' ])
										->getConfig(),
								]
							)
							->getConfig(),
					]
				)
				->getConfig()
		);
	}
}