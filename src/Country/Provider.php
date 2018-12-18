<?php
namespace Common\Country;

use Common\Translator;
use Exception;

class Provider
{
	/**
	 * @param $isoCode
	 * @return Country
	 * @throws Exception
	 */
	public function byIsoCode($isoCode)
	{
		$isoCode = strtoupper($isoCode);

		$filePath = sprintf(
			'vendor/umpirsky/country-list/data/%s/country.php',
			Translator::getLanguage()
		);

		if (!file_exists($filePath))
		{
			throw new Exception('Could not find country list file');
		}

		$list = require $filePath;

		if (!array_key_exists($isoCode, $list))
		{
			throw new Exception('Could not find country with iso code ' . $isoCode);
		}

		return new Country($isoCode, $list[$isoCode]);
	}
}