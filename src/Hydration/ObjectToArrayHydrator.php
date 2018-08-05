<?php
namespace Common\Hydration;

use Common\Util\StringUtil;
use DateTime;
use Doctrine\Common\Collections\Collection;
use Exception;
use ReflectionClass;
use ReflectionException;
use ReflectionMethod;

class ObjectToArrayHydrator
{
	const OBJECT_TO_ARRAY_HYDRATOR_PROPERTY = '@ObjectToArrayHydratorProperty';

	/**
	 * @param $arrayOrObject
	 * @return array
	 */
	public static function hydrate($arrayOrObject)
	{
		try
		{
			if (is_array($arrayOrObject))
			{
				return self::hydrateFromArray($arrayOrObject);
			}

			return self::hydrateFromObject($arrayOrObject);
		}
		catch (Exception $ex)
		{
			error_log($ex->getMessage());
		}

		return [];
	}

	/**
	 * @param $object
	 * @return array|null|string
	 * @throws ReflectionException
	 */
	private static function hydrateFromObject($object)
	{
		if($object instanceof DateTime)
		{
			return $object->format('Y-m-d H:i:s');
		}

		if(!$object instanceof ArrayHydratable)
		{
			if (method_exists($object, '__toString'))
			{
				return (string)$object;
			}

			return null;
		}

		$reflection = new ReflectionClass(get_class($object));

		$asArray = [];

		foreach($reflection->getMethods() as $method)
		{
			$methodName = $method->getName();

			if (!self::methodNameAllowed($methodName))
			{
				continue;
			}

			if (!self::isAllowedProperty($reflection, $method))
			{
				continue;
			}

			$value = $method->invoke($object);

			if(is_object($value))
			{
				if ($value instanceof Collection)
				{
					$value = self::hydrateFromArray($value);
				}
				else
				{
					$value = self::hydrateFromObject($value);
				}
			}
			else if(is_array($value))
			{
				$value = self::hydrateFromArray($value);
			}

			$asArray[self::correctMethodName($methodName)] = $value;
		}

		return $asArray;
	}

	/**
	 * @param $array
	 * @return array
	 * @throws ReflectionException
	 */
	private static function hydrateFromArray($array)
	{
		$values = [];

		foreach($array as $item)
		{
			if(is_object($item))
			{
				$values[] = self::hydrateFromObject($item);
			}
			else
			{
				$values[] = $item;
			}
		}

		return $values;
	}

	/**
	 * @param $methodName
	 * @return string
	 */
	private static function correctMethodName($methodName)
	{
		$firstCharCount = 3;

		if(strpos($methodName, 'is') === 0)
		{
			$firstCharCount = 2;
		}

		return lcfirst(substr($methodName, $firstCharCount));
	}

	/**
	 * @param $methodName
	 * @return bool
	 */
	private static function methodNameAllowed($methodName)
	{
		return strpos($methodName, 'get') === 0 || strpos($methodName, 'is') === 0;
	}

	/**
	 * @param ReflectionClass $reflectionClass
	 * @param ReflectionMethod $method
	 * @return bool
	 */
	private static function isAllowedProperty(ReflectionClass $reflectionClass, ReflectionMethod $method)
	{
		try
		{
			// check if method has necessary doc comment
			if (StringUtil::contains($method->getDocComment(), self::OBJECT_TO_ARRAY_HYDRATOR_PROPERTY))
			{
				return true;
			}

			$cutPosition = StringUtil::startsWith('get', $method->getName()) ? 4 : 3;

			// if method does not, check if property has doc comment
			$propertyName = lcfirst(
				substr($method->getName(), $cutPosition)
			);

			$property = $reflectionClass->getProperty($propertyName);

			if ($property && StringUtil::contains($property->getDocComment(), self::OBJECT_TO_ARRAY_HYDRATOR_PROPERTY))
			{
				return true;
			}

		}
		catch (Exception $ex)
		{
			// do nothing, probably because property does not exist
		}

		return false;
	}
}
