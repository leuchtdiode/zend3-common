<?php
namespace Common\Module\Plugin;

use Common\Module\Plugin;
use Common\Translator;
use Zend\I18n\Translator\TranslatorInterface;

class GlobalTranslatorPlugin implements Plugin
{
	/**
	 * @var TranslatorInterface
	 */
	private $translator;

	/**
	 * @param TranslatorInterface $translator
	 */
	public function __construct(TranslatorInterface $translator)
	{
		$this->translator = $translator;
	}

	public function execute()
	{
		Translator::setInstance($this->translator);

		setlocale(LC_TIME, $this->translator->getLocale());
	}
}