<?php
namespace Common\RequestData\PropertyDefinition;

use Zend\Validator\Date as DateValidator;

class Date extends PropertyDefinition
{
	/**
	 * @return Date
	 */
	public static function create()
	{
		return new self();
	}

	/**
	 */
	public function __construct()
	{
		$this->addValidator(
			new DateValidator()
		);
	}
}