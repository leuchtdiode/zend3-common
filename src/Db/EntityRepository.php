<?php
namespace Common\Db;

use Doctrine\ORM\EntityRepository as DoctrineEntityRepository;
use Doctrine\ORM\NonUniqueResultException;

class EntityRepository extends DoctrineEntityRepository
{
	/**
	 * @param FilterChain $filterChain
	 * @param OrderChain|null $orderChain
	 * @param int $offset
	 * @param int $limit
	 * @return array
	 */
	public function filter(
		FilterChain $filterChain,
		OrderChain $orderChain = null,
		$offset = 0,
		$limit = PHP_INT_MAX
	)
	{
		$queryBuilder = $this->createQueryBuilder('t');

		foreach($filterChain->getFilters() as $filter)
		{
			$filter->addClause($queryBuilder);
		}

		if($orderChain)
		{
			foreach ($orderChain->getOrders() as $order)
			{
				$order->addOrder($queryBuilder);
			}
		}

		$queryBuilder->setFirstResult($offset);
		$queryBuilder->setMaxResults($limit);

		return $queryBuilder
			->getQuery()
			->getResult();
	}

	/**
	 * @param FilterChain|null $filterChain
	 * @param bool $distinct
	 * @return int
	 * @throws NonUniqueResultException
	 */
	public function countWithFilter(FilterChain $filterChain = null, $distinct = false)
	{
		$identifiers = $this
			->getClassMetadata()
			->getIdentifier();

		$queryBuilder = $this
			->createQueryBuilder('t')
			->select('COUNT(' . ($distinct ? 'DISTINCT' : '') . ' t.' . $identifiers[0] . ')');

		if ($filterChain)
		{
			foreach($filterChain->getFilters() as $filter)
			{
				$filter->addClause($queryBuilder);
			}
		}

		return $queryBuilder
			->getQuery()
			->getSingleScalarResult();

	}
}