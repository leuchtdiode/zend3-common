<?php
namespace Db\Common\Filter;

use Common\Db\Filter;
use Doctrine\ORM\QueryBuilder;

abstract class YesNo implements Filter
{
	/**
	 * @var boolean
	 */
	protected $value;

	/**
	 * @return string
	 */
	abstract protected function getColumn();

	/**
	 * @param bool $value
	 */
	private function __construct(bool $value)
	{
		$this->value = $value;
	}

	/**
	 * @return static
	 */
	public static function yes()
	{
		return new static(true);
	}

	/**
	 * @return static
	 */
	public static function no()
	{
		return new static(false);
	}

	/**
	 * @param QueryBuilder $queryBuilder
	 */
	public function addClause(QueryBuilder $queryBuilder)
	{
		$queryBuilder
			->andWhere(
				$queryBuilder->expr()->eq($this->getColumn(), $this->value ? 1 : 0)
			);
	}
}