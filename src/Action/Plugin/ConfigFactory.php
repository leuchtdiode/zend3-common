<?php
namespace Common\Action\Plugin;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class ConfigFactory implements FactoryInterface
{
	/**
	 * @param ContainerInterface $container
	 * @param string $requestedName
	 * @param array|null $options
	 * @return Config|object
	 * @throws \Psr\Container\ContainerExceptionInterface
	 * @throws \Psr\Container\NotFoundExceptionInterface
	 */
	public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
	{
		return new Config(
			$container->get('config')
		);
	}
}