<?php
namespace Common\Db\Filter;

use Common\Db\Filter;
use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\Query\Expr\Andx;
use Doctrine\ORM\Query\Expr\Orx;
use Doctrine\ORM\QueryBuilder;
use RuntimeException;

abstract class Generic implements Filter
{
	const EQ          = 'eq';
	const LIKE        = 'like';
	const STARTS_WITH = 'starts_with';
	const ENDS_WITH   = 'ends_with';

	/**
	 * @var boolean
	 */
	private $value;

	/**
	 * @return array
	 */
	abstract protected function getColumns(): array;

	/**
	 * @param bool $value
	 */
	private function __construct($value)
	{
		$this->value = $value;
	}

	/**
	 * @param $value
	 *
	 * @return static
	 */
	public static function search($value): self
	{
		return new static($value);
	}

	/**
	 * @param QueryBuilder $queryBuilder
	 */
	public function addClause(QueryBuilder $queryBuilder)
	{
		$exp = $queryBuilder->expr();

		$conditions = [];

		$values = preg_split('!\s!', $this->value);

		foreach ($values as $value)
		{
			$conditions[] = $this->getCondition($exp, $value);
		}

		$queryBuilder->andWhere(new Andx($conditions));
	}

	/**
	 * @param Expr $exp
	 * @param string $value
	 *
	 * @return Orx
	 */
	private function getCondition(
		Expr $exp,
		string $value
	): Orx
	{
		$conditions = [];

		foreach ($this->getColumns() as $column => $mode)
		{
			switch ($mode)
			{
				case self::EQ:
					$condition = $exp->eq($column, $exp->literal($value));
					break;

				case self::LIKE:
					$condition = $exp->like($column, $exp->literal("%{$value}%"));
					break;

				case self::STARTS_WITH:
					$condition = $exp->like($column, $exp->literal("{$value}%"));
					break;

				case self::ENDS_WITH:
					$condition = $exp->like($column, $exp->literal("%{$value}"));
					break;

				default:
					throw new RuntimeException("invalid mode in string filter");
			}

			$conditions[] = $condition;
		}

		return new Orx($conditions);
	}
}
