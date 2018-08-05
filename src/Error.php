<?php
namespace Common;

use Common\Hydration\ArrayHydratable;

abstract class Error implements ArrayHydratable
{
	/**
	 * @ObjectToArrayHydratorProperty
	 *
	 * @var Error[]
	 */
	private $subErrors = [];

	/**
	 * @ObjectToArrayHydratorProperty
	 *
	 * @return string
	 */
	abstract public function getCode();

	/**
	 * @ObjectToArrayHydratorProperty
	 *
	 * @return string
	 */
	abstract public function getMessage();

	/**
	 * @return Error[]
	 */
	public function getSubErrors(): array
	{
		return $this->subErrors;
	}

	/**
	 * @param Error $error
	 */
	public function addSubError(Error $error)
	{
		$this->subErrors[] = $error;
	}
}