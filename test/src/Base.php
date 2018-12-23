<?php
namespace CommonTest;

use Zend\Test\PHPUnit\Controller\AbstractControllerTestCase;

class Base extends AbstractControllerTestCase
{
	protected function setUp()
	{
		$this->setApplicationConfig(
			include __DIR__ . '/../../config/test.config.php'
		);

		parent::setUp();
	}
}