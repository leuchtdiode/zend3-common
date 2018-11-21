<?php
namespace Common\RequestData\PropertyDefinition;

use Common\RequestData\Transformer\Boolean as BooleanTransformer;

class Boolean extends PropertyDefinition
{
	/**
	 * @return Boolean
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
		$this->setTransformer(BooleanTransformer::class);

		parent::__construct();
	}
}