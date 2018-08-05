<?php
namespace Common\Module\Plugin;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class GlobalTranslatorPluginFactory implements FactoryInterface
{
	public function __invoke(
		ContainerInterface $container,
		$requestedName,
		array $options = null
	)
	{
		return new GlobalTranslatorPlugin(
			$container->get('MvcTranslator')
		);
	}
}