<?php
namespace CommonTest\Country;

use Common\Country\Provider;
use Common\Translator;
use Exception;
use PHPUnit\Framework\TestCase;
use Zend\I18n\Translator\Translator as I18nTranslator;
use Zend\Mvc\I18n\Translator as MvcTranslator;

class ProviderTest extends TestCase
{
	const ANY_ISO_CODE = 'AT';
	const ANY_LOCALE   = 'de_DE';

	/**
	 *
	 */
	protected function setUp()
	{
		$translator = new I18nTranslator();

		Translator::setInstance(new MvcTranslator($translator));

		parent::setUp();
	}

	/**
	 * @dataProvider isoCodeSet
	 * @throws Exception
	 */
	public function test_results($locale, $isoCode, $expectedLabel)
	{
		Translator::getInstance()->setLocale($locale);

		$country = (new Provider())
			->byIsoCode($isoCode);

		$this->assertEquals($isoCode, $country->getIsoCode());
		$this->assertEquals($expectedLabel, $country->getLabel());
	}

	/**
	 * @expectedException Exception
	 * @expectedExceptionMessage Could not find country list file
	 */
	public function test_exception_thrown_on_invalid_locale()
	{
		Translator::getInstance()->setLocale('xx_XX');

		(new Provider())
			->byIsoCode(self::ANY_ISO_CODE);
	}

	/**
	 * @expectedException Exception
	 * @expectedExceptionMessage Could not find country with iso code XX
	 */
	public function test_exception_thrown_on_invalid_iso_code()
	{
		Translator::getInstance()->setLocale(self::ANY_LOCALE);

		(new Provider())
			->byIsoCode('xx');
	}

	/**
	 * @return array
	 */
	public function isoCodeSet()
	{
		return [
			['de_DE', 'AT', 'Österreich'],
			['en_EN', 'AT', 'Austria'],
			['fr_FR', 'AT', 'Autriche'],
			['de_DE', 'DE', 'Deutschland'],
			['en_EN', 'DE', 'Germany'],
			['fr_FR', 'DE', 'Allemagne'],
		];
	}
}