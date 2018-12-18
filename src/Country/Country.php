<?php
namespace Common\Country;

class Country
{
	/**
	 * @var string
	 */
	private $isoCode;

	/**
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