<?php
namespace Common\Country;

use Common\Translator;
use Exception;
use Zend\Validator\AbstractValidator;

class Validator extends AbstractValidator
{
	const INVALID = 'invalid';

	/**
	 * @var Provider
	 */
	private $countryProvider;

	/**
	 * @param Provider $countryProvider
	 */
	public function __construct(Provider $countryProvider)
	{
		$this->countryProvider = $countryProvider;

		parent::__construct(
			[
				'messageTemplates' => [
					self::INVALID => Translator::translate('Land %value% ist nicht zulässig')
				],
			]
		);
	}

	/**
	 * @param string $value
	 * @return bool
	 */
	public function isValid($value)
	{
		$this->setValue($value);

		try
		{
			$this->countryProvider->byIsoCode($value);

			return true;
		}
		catch (Exception $ex)
		{
			// do nothing
		}

		return false;
	}
}