<?php
namespace Common\RequestData;

use Common\RequestData\Error\PropertyIsInvalid;
use Common\RequestData\Error\PropertyIsMandatory;
use Common\RequestData\PropertyDefinition\PropertyDefinition;
use Common\Translator;
use Common\Util\StringUtil;
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
	protected $container;

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

				if (!$this->data) // try again POST data
				{
					parse_str($content, $this->data);
				}
			}
		}

		return $this;
	}

	/**
	 * @param array $data
	 * @return Data
	 */
	public function setData($data)
	{
		$this->data = $data;
		return $this;
	}

	/**
	 * @return Values
	 * @throws Exception
	 */
	public function getValues()
	{
		$values = new Values();

		$this->handleDefinitions(
			$values,
			$this->getDefinitions()
		);

		return $values;
	}

	/**
	 * @param Values $values
	 * @param PropertyDefinition[] $definitions
	 * @throws Exception
	 */
	private function handleDefinitions(Values $values, array $definitions)
	{
		foreach ($definitions as $definition)
		{
			$rawValue = $this->getRawValue($definition);

			$value = new Value();
			$value->setName($definition->getName());
			$value->setValue($rawValue);

			$values->addValue($value);

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

					$value->setValue($rawValue);
				}
				catch (Exception $ex)
				{
					$value->setValue(null);

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
				$value->setValue(null);

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
	}

	/**
	 * @param PropertyDefinition $definition
	 * @return mixed|null
	 */
	private function getRawValue(PropertyDefinition $definition)
	{
		$name = $definition->getName();

		if (StringUtil::contains($name, '.')) // nested property
		{
			$arrayIndexes = explode('.', $name);

			$rawValue = $this->data[$arrayIndexes[0]] ?? null;

			if ($rawValue === null)
			{
				return null;
			}

			foreach (array_slice($arrayIndexes, 1) as $arrIndex)
			{
				$rawValue = $rawValue[$arrIndex] ?? null;

				if ($rawValue === null)
				{
					return null;
				}
			}

			return $rawValue;
		}

		return $this->data[$name] ?? null;
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
