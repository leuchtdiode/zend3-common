<?php
namespace Common;

use Exception;
use ReflectionClass;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\AbstractFactoryInterface;

abstract class AbstractDefaultFactory implements AbstractFactoryInterface
{
	/**
	 * @var ContainerInterface
	 */
	private $container;

	/**
	 * @var string
	 */
	private $requestedName;

	abstract protected function getNamespace();

	public function canCreate(
		ContainerInterface $container,
		$requestedName
	)
	{
		return strpos($requestedName, $this->getNamespace() . '\\') === 0;
	}

	public function __invoke(
		ContainerInterface $container,
		$requestedName,
		array $options = null
	)
	{
		$this->container		= $container;
		$this->requestedName 	= $requestedName;

		$factoryClassName = $requestedName . 'Factory';

		if (class_exists($factoryClassName))
		{
			return (new $factoryClassName())->__invoke($container, $requestedName, $options);
		}

		try
		{
			if (($object = $this->tryToLoadWithReflection()))
			{
				return $object;
			}
		}
		catch (Exception $ex)
		{
			throw $ex;
		}

		return new $requestedName;
	}

	private function tryToLoadWithReflection()
	{
		$class = new ReflectionClass($this->requestedName);

		if(!($constructor = $class->getConstructor()))
		{
			return;
		}

		if(!($params = $constructor->getParameters()))
		{
			return;
		}

		$parameterInstances = [];

		foreach($params as $p)
		{
			if($p->getName() === 'container')
			{
				$parameterInstances[] = $this->container;
			}
			else if($p->getClass())
			{
				try
				{
					$parameterInstances[] = $this->container->get(
						$p->getClass()->getName()
					);
				}
				catch (Exception $ex)
				{
					error_log($ex->getMessage());

					throw $ex;
				}
			}
			else if($p->isArray() && $p->getName() === 'config')
			{
				$parameterInstances[] = $this->container->get('Config');
			}
		}

		return $class->newInstanceArgs($parameterInstances);
	}
}