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
	 * @throws Exception
	 */
	public function delete($entity)
	{
		$this->entityManager->remove($entity);
		$this->entityManager->flush($entity);
	}
}