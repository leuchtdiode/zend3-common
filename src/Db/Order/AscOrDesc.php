<?php
namespace Common\Db\Order;

use Common\Db\Order;
use Doctrine\ORM\QueryBuilder;

abstract class AscOrDesc implements Order
{
	/**
	 * @var string
	 */
	protected $direction;

	/**
	 * @param string $direction
	 */
	private function __construct(string $direction)
	{
		$this->direction = $direction;
	}

	/**
	 * @return string
	 */
	abstract protected function getField();

	/**
	 * @param string $direction
	 * @return AscOrDesc
	 */
	public static function withDirection($direction)
	{
		return new static($direction);
	}

	/**
	 * @return AscOrDesc
	 */
	public static function asc()
	{
		return new static('ASC');
	}

	/**
	 * @return AscOrDesc
	 */
	public static function desc()
	{
		return new static('DESC');
	}

	/**
	 * @return string
	 */
	protected function getDirection(): string
	{
		return $this->direction;
	}

	/**
	 * @param QueryBuilder $queryBuilder
	 */
	public function addOrder(QueryBuilder $queryBuilder)
	{
		$queryBuilder->addOrderBy(
			$this->getField(),
			$this->direction
		);
	}
}