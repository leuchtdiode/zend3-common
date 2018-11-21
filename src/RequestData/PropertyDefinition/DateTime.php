<?php
namespace Common\RequestData\PropertyDefinition;

use Zend\I18n\Validator\DateTime as DateTimeValidator;

class DateTime extends PropertyDefinition
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
			new DateTimeValidator(
				[
					'pattern' => 'Y-m-d H:i:s'
				]
			)
		);
	}
}