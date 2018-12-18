<?php
namespace Common\Country;

use Common\Hydration\ArrayHydratable;

class Country implements ArrayHydratable
{
	/**
	 * @ObjectToArrayHydratorProperty
	 *
	 * @var string
	 */
	private $isoCode;

	/**
	 * @ObjectToArrayHydratorProperty
	 *
	 * @var string
	 */
	private $label;

	/**
	 * @param string $isoCode
	 * @param string $label
	 */
	public function __construct(string $isoCode, string $label)
	{
		$this->isoCode = $isoCode;
		$this->label   = $label;
	}

	/**
	 * @return string
	 */
	public function getIsoCode(): string
	{
		return $this->isoCode;
	}

	/**
	 * @return string
	 */
	public function getLabel(): string
	{
		return $this->label;
	}
}