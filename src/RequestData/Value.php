<?php
namespace Common\RequestData;

use Common\Error;

class Value
{
	/**
	 * @var string
	 */
	private $name;

	/**
	 * @var mixed|null
	 */
	private $value;

	/**
	 * @var Error[]
	 */
	private $errors = [];

	/**
	 * @param Error $error
	 */
	public function addError(Error $error)
	{
		$this->errors[] = $error;
	}

	/**
	 * @return bool
	 */
	public function hasErrors()
	{
		return !empty($this->errors);
	}

	/**
	 * @param string $name
	 * @return Value
	 */
	public function setName(string $name): Value
	{
		$this->name = $name;
		return $this;
	}

	/**
	 * @param mixed|null $value
	 */
	public function setValue($value): void
	{
		$this->value = $value;
	}

	/**
	 * @return string
	 */
	public function getName(): string
	{
		return $this->name;
	}

	/**
	 * @return mixed
	 */
	public function getValue()
	{
		return $this->value;
	}

	/**
	 * @return Error[]
	 */
	public function getErrors(): array
	{
		return $this->errors;
	}
}