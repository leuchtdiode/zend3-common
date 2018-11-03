<?php
namespace Common\RequestData;

use Common\Error;

class Values
{
	/**
	 * @var Value[]
	 */
	private $values = [];

	/**
	 * @param Value $value
	 */
	public function addValue(Value $value)
	{
		$this->values[] = $value;
	}

	/**
	 * @return Error[]
	 */
	public function getErrors()
	{
		$errors = [];

		foreach ($this->values as $value)
		{
			$errors = array_merge_recursive($errors, $value->getErrors());
		}

		return $errors;
	}

	/**
	 * @return bool
	 */
	public function hasErrors()
	{
		return !empty($this->getErrors());
	}

	/**
	 * @return Value[]
	 */
	public function getValues(): array
	{
		return $this->values;
	}
}