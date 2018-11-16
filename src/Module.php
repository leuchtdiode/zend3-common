<?php
namespace Common;

use Common\Module\Plugin\GlobalTranslatorPlugin;
use Common\Module\PluginChain;
use Zend\Mvc\MvcEvent;

class Module
{
	/**
	 * @return array
	 */
	public function getConfig()
	{
		return include __DIR__ . '/../config/module.config.php';
	}

	/**
	 * @param MvcEvent $e
	 */
	public function onBootstrap(MvcEvent $e)
	{
		$eventManager 	= $e->getApplication()->getEventManager();
		$serviceManager = $e->getApplication()->getServiceManager();

		$eventManager->attach(MvcEvent::EVENT_ROUTE, function() use ($serviceManager)
		{
			PluginChain::create()
				->addPlugin($serviceManager->get(GlobalTranslatorPlugin::class))
				->executeAll();
		});
	}
}