<?php
namespace CommonTest\Router;

use Common\Router\ConsoleRouteCreator;
use CommonTest\Base;

class ConsoleRouteCreatorTest extends Base
{
	public function test_route()
	{
		$this->assertEquals(
			[
				'type'    => 'Zend\Mvc\Console\Router\Simple',
				'options' => [
					'route'    => 'test route <file>',
					'defaults' => [
						'controller' => 'AnyNamespace\Action',
						'action'     => 'execute',
					],
				],
			],
			ConsoleRouteCreator::create()
				->setRoute('test route <file>')
				->setAction('AnyNamespace\Action')
				->getConfig()
		);
	}
}