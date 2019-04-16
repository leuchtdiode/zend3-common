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
	 * @param string $name
	 * @return Value|null
	 */
	public function get($name)
	{
		foreach ($this->values as $value)
		{
			if ($value->getName() === $name)
			{
				return $value;
			}
		}

		return null;
	}

	/**
	 * @param string $name
	 * @return mixed|null
	 */
	public function getRawValue($name)
	{
		$value = $this->get($name);

		return $value
			? $value->getValue()
			: null;
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