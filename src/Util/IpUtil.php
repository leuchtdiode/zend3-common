<?php
namespace Common\Util;

class IpUtil
{
	/**
	 * @return string|null
	 */
	public static function getIp()
	{
		$ip = null;

		foreach ([ 'HTTP_X_REAL_IP', 'REMOTE_ADDR' ] as $property)
		{
			$ip = filter_input(INPUT_SERVER, $property);

			if ($ip)
			{
				break;
			}
		}

		return $ip;
	}
}