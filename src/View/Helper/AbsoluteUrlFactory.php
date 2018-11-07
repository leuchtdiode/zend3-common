<?php
namespace Common\View\Helper;

use Common\Router\BaseUrlProvider;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class AbsoluteUrlFactory implements FactoryInterface
{
	public function __invoke(
		ContainerInterface $container,
		$requestedName,
		array $options = null
	)
	{
		return new AbsoluteUrl(
			$container->get(BaseUrlProvider::class)
		);
	}
}