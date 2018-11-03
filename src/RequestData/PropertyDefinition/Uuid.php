<?php
namespace Common\RequestData\PropertyDefinition;

use Zend\Validator\Uuid as UuidValidator;

class Uuid extends PropertyDefinition
{
	/**
	 * @return Uuid
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
			new UuidValidator()
		);
	}
}