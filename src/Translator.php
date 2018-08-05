<?php
namespace Common;

use Zend\Mvc\I18n\Translator as ZendTranslator;

class Translator
{
	/**
	 * @var ZendTranslator
	 */
	private static $instance;

	/**
	 * @param ZendTranslator $translator
	 */
	public static function setInstance(ZendTranslator $translator)
	{
		self::$instance = $translator;
	}

	/**
	 * @return ZendTranslator
	 */
	public static function getInstance()
	{
		return self::$instance;
	}

	/**
	 * @param string $text
	 * @return string
	 */
	public static function translate(string $text)
	{
		return self::$instance->translate($text);
	}

	/**
	 * @return string
	 */
	public static function getLocale()
	{
		return self::$instance->getLocale();
	}

	/**
	 * @return string
	 */
	public static function getLanguage()
	{
		list($language) = explode('_', self::getLocale());

		return $language;
	}
}