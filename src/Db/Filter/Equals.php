<?php
namespace Common\Db\Filter;

use Common\Db\Filter;
use Doctrine\ORM\QueryBuilder;

abstract class Equals implements Filter
{
	const VALUE    = 'value';
	const NULL     = 'null';
	const NOT_NULL = 'notNull';

	/**
	 * @var string
	 */
	private $type;

	/**
	 * @var mixed|null
	 */
	private $parameter;

	/**
	 * @return string
	 */
	abstract protected function getField();

	/**
	 * @return string
	 */
	abstract protected function getParameterName();

	/**
	 * @param $type
	 * @param mixed $parameter
	 */
	private function __construct($type, $parameter = null)
	{
		$this->type      = $type;
		$this->parameter = $parameter;
	}

	/**
	 * @param mixed $parameter
	 * @return static
	 */
	public static function is($parameter)
	{
		return new static(self::VALUE, $parameter);
	}

	/**
	 * @return Equals
	 */
	public static function isNull()
	{
		return new static(self::NULL);
	}

	/**
	 * @return Equals
	 */
	public static function isNotNull()
	{
		return new static(self::NOT_NULL);
	}

	/**
	 * @param QueryBuilder $queryBuilder
	 */
	public function addClause(QueryBuilder $queryBuilder)
	{
		switch ($this->type)
		{
			case self::VALUE:

				$queryBuilder
					->andWhere(
						$queryBuilder
							->expr()
							->eq($this->getField(), ':' . $this->getParameterName())
					)
					->setParameter($this->getParameterName(), $this->parameter);

				break;

			case self::NULL:

				$queryBuilder
					->andWhere(
						$queryBuilder
							->expr()
							->isNull($this->getField())
					);

				break;

			case self::NOT_NULL:

				$queryBuilder
					->andWhere(
						$queryBuilder
							->expr()
							->isNotNull($this->getField())
					);

				break;
		}
	}
}