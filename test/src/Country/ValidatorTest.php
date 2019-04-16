<?php
namespace CommonTest\Country;

use Common\Country\Validator;
use CommonTest\Base;

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

		$this->setDummyTranslator();

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