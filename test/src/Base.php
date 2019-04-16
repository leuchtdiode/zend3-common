<?php
namespace CommonTest;

use Common\Translator;
use Zend\I18n\Translator\Translator as I18nTranslator;
use Zend\Mvc\I18n\Translator as MvcTranslator;
use Zend\Test\PHPUnit\Controller\AbstractControllerTestCase;

class Base extends AbstractControllerTestCase
{
	/**
	 *
	 */
	protected function setUp()
	{
		$this->setApplicationConfig(
			include __DIR__ . '/../../config/test.config.php'
		);

		parent::setUp();
	}

	/**
	 *
	 */
	protected function setDummyTranslator()
	{
		$translator = new I18nTranslator();

		Translator::setInstance(new MvcTranslator($translator));
	}
}