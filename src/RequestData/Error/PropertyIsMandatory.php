<?php
namespace Common\RequestData\Error;

use Common\Error;
use Common\Translator;

class PropertyIsMandatory extends Error
{
	/**
	 * @var string
	 */
	private $name;

	/**
	 * @param string $name
	 */
	private function __construct(string $name)
	{
		$this->name = $name;
	}

	/**
	 * @param $name
	 * @return PropertyIsMandatory
	 */
	public static function create($name)
	{
		return new self($name);
	}

	/**
	 * @ObjectToArrayHydratorProperty
	 *
	 * @return string
	 */
	public function getCode()
	{
		return 'MANDATORY_PROPERTY_MISSING';
	}

	/**
	 * @ObjectToArrayHydratorProperty
	 *
	 * @return string
	 */
	public function getMessage()
	{
		return Translator::translate('Eigenschaft ' . $this->name . ' ist verpflichtend');
	}
}