<?php
namespace Common\Country;

use Common\Translator;
use Exception;

class Provider
{
	/**
	 * @return Country[]
	 * @throws Exception
	 */
	public function all()
	{
		$filePath = sprintf(
			'vendor/umpirsky/country-list/data/%s/country.php',
			Translator::getLanguage()
		);

		if (!file_exists($filePath))
		{
			throw new Exception('Could not find country list file');
		}

		$countriesArray = require $filePath;

		$countries = [];

		foreach ($countriesArray as $isoCode => $name)
		{
			$countries[] = new Country($isoCode, $name);
		}

		return $countries;
	}

	/**
	 * @param $isoCode
	 * @return Country
	 * @throws Exception
	 */
	public function byIsoCode($isoCode)
	{
		$isoCode = strtoupper($isoCode);

		$countries = $this->all();

		foreach ($countries as $country)
		{
			if ($country->getIsoCode() === $isoCode)
			{
				return $country;
			}
		}

		throw new Exception('Could not find country with iso code ' . $isoCode);
	}
}