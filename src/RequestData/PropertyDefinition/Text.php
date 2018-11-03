<?php
namespace Common\RequestData\PropertyDefinition;

class Text extends PropertyDefinition
{
	/**
	 * @return Text
	 */
	public static function create()
	{
		return new self();
	}
}