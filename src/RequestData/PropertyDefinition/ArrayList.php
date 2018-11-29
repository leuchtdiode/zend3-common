<?php
namespace Common\RequestData\PropertyDefinition;

use Common\RequestData\Transformer\Boolean as BooleanTransformer;
use Zend\Validator\Callback;

class ArrayList extends PropertyDefinition
{
	/**
	 * @return ArrayList
	 */
	public static function create()
	{
		return new self();
	}

	/**
	 */
	public function __construct()
	{
		parent::__construct();

		$isArrayValidator = new Callback(
			function ($value)
			{
				return is_array($value);
			}
		);
		$isArrayValidator->setMessage('Der Wert ist kein Array');

		$this->addValidator($isArrayValidator);
	}
}