<?php
namespace Common\RequestData\PropertyDefinition;

use Zend\Validator\Digits;

class Integer extends PropertyDefinition
{
	/**
	 * @return Integer
	 */
	public static function create()
	{
		return new self();
	}

	/**
	 * @param $value
	 * @return bool
	 */
	public function valueIsEmpty($value)
	{
		return $value === null;
	}

	/**
	 */
	public function __construct()
	{
		$this->addValidator(
			new Digits()
		);
	}
}