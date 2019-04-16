<?php
namespace CommonTest\Country;

use Common\Country\Validator;
use Common\Translator;
use CommonTest\Base;
use Zend\I18n\Translator\Translator as I18nTranslator;
use Zend\Mvc\I18n\Translator as MvcTranslator;

class ValidatorTest extends Base
{
	/**
	 * @var Validator
	 */
	private $validator;

	/**
	 *
	 */
	protected function setUp()
	{
		parent::setUp();

		$translator = new I18nTranslator();

		Translator::setInstance(new MvcTranslator($translator));

		$this->validator = $this
			->getApplicationServiceLocator()
			->get(Validator::class);
	}

	/**
	 *
	 */
	public function test_valid_country()
	{
		$this->assertTrue(
			$this->validator->isValid('AT')
		);
	}

	/**
	 */
	public function test_invalid_country()
	{
		$this->assertFalse(
			$this->validator->isValid('XX')
		);
	}
}