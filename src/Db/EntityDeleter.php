<?php
namespace Common\Db;

use Doctrine\ORM\EntityManager;
use Exception;

class EntityDeleter
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
	 * @param $entity
	 * @param bool $flush
	 * @throws Exception
	 */
	public function delete($entity, $flush = true)
	{
		$this->entityManager->remove($entity);
		
		if ($flush)
		{
			$this->entityManager->flush($entity);
		}
	}
	
	/**
	* @param mixed $entity
	* @param FilterChain $filterChain
	*/
	public function filterDelete($entity, FilterChain $filterChain)
	{
		$queryBuilder = $this->entityManager
			->getRepository(
				is_object($entity)
					? $entity::class
					: $entity
			)
			->createQueryBuilder('t');

		foreach ($filterChain->getFilters() as $filter)
		{
			$filter->addClause($queryBuilder);
		}

		$queryBuilder->delete();

		return $queryBuilder->getQuery()->execute();
	}
}