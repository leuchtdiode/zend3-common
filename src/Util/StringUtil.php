<?php
namespace Common\Util;

class StringUtil
{
	/**
	 * @param $string
	 * @param $searchString
	 * @return bool
	 */
	public static function contains($string, $searchString)
	{
		return strpos($string, $searchString) !== false;
	}

	/**
	 * @param $string
	 * @param $searchString
	 * @return bool
	 */
	public static function startsWith($string, $searchString)
	{
		return strpos($string, $searchString) === 0;
	}

	/**
	 * @param $string
	 * @param $searchString
	 * @return bool
	 */
	public static function endsWith($string, $searchString)
	{
		$length = strlen($searchString);

		return substr($string, -$length) === $searchString;
	}

	/**
	 * @param string $a
	 * @param string $b
	 * @return int
	 */
	public static function compare($a, $b)
	{
		return strcasecmp($a, $b);
	}
}