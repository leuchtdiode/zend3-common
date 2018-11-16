<?php
namespace Common\Module\Plugin;

use Common\Module\Plugin;
use Common\Translator;
use Zend\I18n\Translator\TranslatorInterface;

class GlobalTranslatorPlugin implements Plugin
{
	/**
	 * @var array
	 */
	private $config;

	/**
	 * @var TranslatorInterface
	 */
	private $translator;

	/**
	 * @param array $config
	 * @param TranslatorInterface $translator
	 */
	public function __construct(array $config, TranslatorInterface $translator)
	{
		$this->config     = $config;
		$this->translator = $translator;
	}

	/**
	 *
	 */
	public function execute()
	{
		if (!$this->config['common']['translator']['global']['enabled'])
		{
			return;
		}

		Translator::setInstance($this->translator);

		setlocale(LC_TIME, $this->translator->getLocale());
	}
}