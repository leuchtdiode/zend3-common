<?php
namespace Common\Db\Filter;

use DateTime;
use Common\Db\Filter;
use Doctrine\ORM\QueryBuilder;
use Exception;
use RuntimeException;

abstract class Date implements Filter
{
	const IN_DAYS = 'in_days';
	const BEFORE  = 'before';
	const AFTER   = 'after';
	const MODULO  = 'modulo';

	/**
	 * @var DateTime
	 */
	protected $value;

	/**
	 * @var string
	 */
	protected $mode;

	/**
	 * @return string
	 */
	abstract protected function getColumn();

	/**
	 * @param DateTime $value
	 * @param string $mode
	 */
	private function __construct(
		DateTime $value,
		$mode = self::IN_DAYS
	)
	{
		$this->value = $value;
		$this->mode  = $mode;
	}

	/**
	 * @param int $days
	 * @return static
	 * @throws Exception
	 */
	public static function inDays(int $days)
	{
		$date = new DateTime();
		$date->modify(
			sprintf(
				'%s%d days',
				$days < 0 ? '-' : '+',
				abs($days)
			)
		);

		return new static($date, self::IN_DAYS);
	}

	/**
	 * @param DateTime $date
	 *
	 * @return static
	 */
	public static function before(DateTime $date)
	{
		return new static($date, self::BEFORE);
	}

	/**
	 * @param DateTime $date
	 *
	 * @return static
	 */
	public static function after(DateTime $date)
	{
		return new static($date, self::AFTER);
	}

	/**
	 * @param int $days
	 * @return static
	 * @throws Exception
	 */
	public static function modulo(int $days)
	{
		$date = new DateTime();
		$date->modify(
			sprintf(
				'%s%d days',
				$days < 0 ? '-' : '+',
				abs($days)
			)
		);

		return new static($date, self::MODULO);
	}

	/**
	 * @param QueryBuilder $queryBuilder
	 */
	public function addClause(QueryBuilder $queryBuilder)
	{
		$exp = $queryBuilder->expr();

		switch ($this->mode)
		{
			case self::IN_DAYS:
				$queryBuilder->andWhere(
					$exp->eq(
						"DATE_FORMAT({$this->getColumn()}, '%Y-%m-%d')",
						$exp->literal($this->value->format('Y-m-d'))
					)
				);

				break;

			case self::BEFORE:
				$queryBuilder->andWhere(
					$exp->lt(
						$this->getColumn(),
						$exp->literal($this->value->format('Y-m-d H:i:s'))
					)
				);

				break;

			case self::AFTER:
				$queryBuilder->andWhere(
					$exp->gt(
						$this->getColumn(),
						$exp->literal($this->value->format('Y-m-d H:i:s'))
					)
				);

				break;

			case self::MODULO:
				$queryBuilder->andWhere(
					$exp->eq(
						"DATE_FORMAT({$this->getColumn()}, '%m-%d')",
						$exp->literal($this->value->format('m-d'))
					)
				);

				break;

			default:
				throw new RuntimeException("invalid mode in string filter");
		}

	}
}
