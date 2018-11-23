<?php
namespace Common\Db\Filter;

use Common\Db\Filter;
use Doctrine\ORM\QueryBuilder;

abstract class Equals implements Filter
{
	/**
	 * @var mixed
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
	 * @param mixed $parameter
	 */
	private function __construct($parameter)
	{
		$this->parameter = $parameter;
	}

	/**
	 * @param mixed $parameter
	 * @return static
	 */
	public static function is($parameter)
	{
		return new static($parameter);
	}

	/**
	 * @param QueryBuilder $queryBuilder
	 */
	public function addClause(QueryBuilder $queryBuilder)
	{
		if ($this->parameter === null)
		{
			$queryBuilder
				->andWhere(
					$queryBuilder->expr()->isNull($this->getField())
				);

			return;
		}

		$queryBuilder
			->andWhere($this->getField() . ' = :' . $this->getParameterName())
			->setParameter($this->getParameterName(), $this->parameter);
	}
}