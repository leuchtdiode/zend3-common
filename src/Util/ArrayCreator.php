<?php
namespace Common\Util;

class ArrayCreator
{
	/**
	 * @var array
	 */
	private $array = [];

	/**
	 * @return ArrayCreator
	 */
	public static function create()
	{
		return new self();
	}

	/**
	 * @param mixed $value
	 * @param string|null $key
	 * @return ArrayCreator
	 */
	public function addIfNotEmpty($value, ?string $key = null)
	{
		if (empty($value))
		{
			return $this;
		}

		return $this->add($value, $key);
	}

	/**
	 * @param mixed $value
	 * @param string|null $key
	 * @return ArrayCreator
	 */
	public function add($value, ?string $key = null)
	{
		if ($key !== null)
		{
			$this->array[$key] = $value;

			return $this;
		}

		$this->array[] = $value;

		return $this;
	}

	/**
	 * @return array
	 */
	public function getArray()
	{
		return $this->array;
	}
}