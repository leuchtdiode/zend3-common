<?php
namespace Common\Db;

use Doctrine\ORM\EntityManager;

class EntityFilterDeleter
{
	/**
	 * @var EntityManager
	 */
	protected $entityManager;

	/**
	 * @param EntityManager $entityManager
	 */
	public function __construct(EntityManager $entityManager)
	{
		$this->entityManager = $entityManager;
	}

	/**
	 * @param string $entityClass
	 * @param FilterChain $filterChain
	 * @return int
	 */
	public function filterDelete($entityClass, FilterChain $filterChain)
	{
		$queryBuilder = $this->entityManager
			->getRepository($entityClass)
			->createQueryBuilder('t');

		foreach ($filterChain->getFilters() as $filter)
		{
			$filter->addClause($queryBuilder);
		}

		return $queryBuilder
			->delete()
			->getQuery()
			->execute();
	}
}