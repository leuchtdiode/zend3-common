<?php
namespace Common\RequestData\PropertyDefinition;

use Zend\Validator\ValidatorChain;
use Zend\Validator\ValidatorInterface;

abstract class PropertyDefinition
{
	/**
	 * @var string
	 */
	protected $name;

	/**
	 * @var string|null
	 */
	protected $label;

	/**
	 * @var mixed|null
	 */
	protected $defaultValue;

	/**
	 * @var boolean
	 */
	protected $required;

	/**
	 * @var ValidatorChain
	 */
	protected $validatorChain;

	/**
	 */
	public function __construct()
	{
		$this->validatorChain = new ValidatorChain();
	}

	/**
	 * @param ValidatorInterface $validator
	 */
	public function addValidator(ValidatorInterface $validator)
	{
		if (!$this->validatorChain)
		{
			$this->validatorChain = new ValidatorChain();
		}

		$this->validatorChain->attach($validator);
	}

	/**
	 * @return string
	 */
	public function getName(): string
	{
		return $this->name;
	}

	/**
	 * @param string $name
	 * @return PropertyDefinition
	 */
	public function setName(string $name): PropertyDefinition
	{
		$this->name = $name;
		return $this;
	}

	/**
	 * @return null|string
	 */
	public function getLabel(): ?string
	{
		return $this->label;
	}

	/**
	 * @param null|string $label
	 * @return PropertyDefinition
	 */
	public function setLabel(?string $label): PropertyDefinition
	{
		$this->label = $label;
		return $this;
	}

	/**
	 * @return mixed|null
	 */
	public function getDefaultValue()
	{
		return $this->defaultValue;
	}

	/**
	 * @param mixed|null $defaultValue
	 * @return PropertyDefinition
	 */
	public function setDefaultValue($defaultValue): PropertyDefinition
	{
		$this->defaultValue = $defaultValue;
		return $this;
	}

	/**
	 * @return bool
	 */
	public function isRequired(): bool
	{
		return $this->required;
	}

	/**
	 * @param bool $required
	 * @return PropertyDefinition
	 */
	public function setRequired(bool $required): PropertyDefinition
	{
		$this->required = $required;
		return $this;
	}

	/**
	 * @return ValidatorChain
	 */
	public function getValidatorChain(): ValidatorChain
	{
		return $this->validatorChain;
	}
}