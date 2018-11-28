<?php
namespace Common\RequestData;

use Common\RequestData\Error\PropertyIsInvalid;
use Common\RequestData\Error\PropertyIsMandatory;
use Common\RequestData\PropertyDefinition\PropertyDefinition;
use Common\Translator;
use Exception;
use Psr\Container\ContainerInterface;
use Zend\Stdlib\RequestInterface;

abstract class Data
{
	/**
	 * @return PropertyDefinition[]
	 */
	abstract protected function getDefinitions();

	/**
	 * @var ContainerInterface
	 */
	private $container;

	/**
	 * @var array
	 */
	private $data;

	/**
	 * @param ContainerInterface $container
	 */
	public function __construct(ContainerInterface $container)
	{
		$this->container = $container;
	}

	/**
	 * @param RequestInterface $request
	 * @return Data
	 */
	public function setRequest(RequestInterface $request)
	{
		if ($request->getMethod() === 'GET')
		{
			$this->data = $request
				->getQuery()
				->toArray();
		}
		else
		{
			if (($content = $request->getContent()))
			{
				$this->data = json_decode($content, JSON_OBJECT_AS_ARRAY);
			}
		}

		return $this;
	}

	/**
	 * @return Values
	 * @throws Exception
	 */
	public function getValues()
	{
		$values = new Values();

		foreach ($this->getDefinitions() as $definition)
		{
			$rawValue = $this->data[$definition->getName()] ?? null;

			if ($rawValue === null && !$definition->isRequired())
			{
				if (($defaultValue = $definition->getDefaultValue()) !== null)
				{
					$rawValue = $defaultValue;
				}
				else
				{
					continue;
				}
			}

			$value = new Value();
			$value->setName($definition->getName());
			$value->setValue($rawValue);

			$values->addValue($value);

			if ($definition->valueIsEmpty($rawValue) && $definition->isRequired())
			{
				$value->addError(
					PropertyIsMandatory::create(
						$this->getErrorLabel($definition)
					)
				);

				continue;
			}

			$transformerClass = $definition->getTransformer();

			if ($transformerClass)
			{
				$transformer = $this->container->get($transformerClass);

				if (!$transformer)
				{
					throw new Exception('Transformer ' . $transformerClass . ' is not available');
				}

				try
				{
					$rawValue = $transformer->transform($rawValue);
				}
				catch (Exception $ex)
				{
					$value->addError(
						PropertyIsInvalid::create(
							$this->getErrorLabel($definition),
							$ex->getMessage()
						)
					);

					continue;
				}
			}

			$validatorChain = $definition->getValidatorChain();

			if ($validatorChain && !$validatorChain->isValid($rawValue))
			{
				foreach ($validatorChain->getMessages() as $message)
				{
					$value->addError(
						PropertyIsInvalid::create(
							$this->getErrorLabel($definition),
							$message
						)
					);
				}

				continue;
			}
		}

		return $values;
	}

	/**
	 * @param PropertyDefinition $definition
	 * @return string
	 */
	private function getErrorLabel(PropertyDefinition $definition)
	{
		return ($label = $definition->getLabel())
			? Translator::translate($label)
			: $definition->getName();
	}
}