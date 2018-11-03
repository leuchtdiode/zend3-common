<?php
namespace Common\RequestData;

use Common\RequestData\Error\PropertyIsInvalid;
use Common\RequestData\Error\PropertyIsMandatory;
use Common\RequestData\PropertyDefinition\PropertyDefinition;
use Zend\Stdlib\RequestInterface;

abstract class Data
{
	/**
	 * @return PropertyDefinition[]
	 */
	abstract protected function getDefinitions();

	/**
	 * @var array
	 */
	private $data;

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
	 */
	public function getValues()
	{
		$values = new Values();

		foreach ($this->getDefinitions() as $definition)
		{
			$rawValue = $this->data[$definition->getName()] ?? null;

			$value = new Value();
			$value->setName($definition->getName());
			$value->setValue($rawValue);

			$values->addValue($value);

			if (empty($rawValue) && $definition->isRequired())
			{
				$value->addError(
					PropertyIsMandatory::create($definition->getName())
				);

				continue;
			}

			$validatorChain = $definition->getValidatorChain();

			if (!$validatorChain->isValid($rawValue))
			{
				foreach ($validatorChain->getMessages() as $message)
				{
					$value->addError(
						PropertyIsInvalid::create($definition->getName(), $message)
					);
				}

				continue;
			}
		}

		return $values;
	}
}