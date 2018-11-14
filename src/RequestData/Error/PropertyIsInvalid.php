<?php
namespace Common\RequestData\Error;

use Common\Error;
use Common\Translator;

class PropertyIsInvalid extends Error
{
	/**
	 * @var string
	 */
	private $name;

	/**
	 * @var string
	 */
	private $message;

	/**
	 * @param string $name
	 * @param string $message
	 */
	private function __construct(string $name, string $message)
	{
		$this->name    = $name;
		$this->message = $message;
	}

	/**
	 * @param $name
	 * @param $message
	 * @return PropertyIsInvalid
	 */
	public static function create($name, $message)
	{
		return new self($name, $message);
	}

	/**
	 * @ObjectToArrayHydratorProperty
	 *
	 * @return string
	 */
	public function getCode()
	{
		return 'PROPERTY_INVALID';
	}

	/**
	 * @ObjectToArrayHydratorProperty
	 *
	 * @return string
	 */
	public function getMessage()
	{
		return Translator::translate($this->name . ' ist ungültig (' . $this->message . ')');
	}
}