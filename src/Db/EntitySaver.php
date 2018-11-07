<?php
namespace Common\Db;

use Doctrine\ORM\EntityManager;
use Exception;

class EntitySaver
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
	public function save($entity, $flush = true)
	{
		$this->entityManager->persist($entity);

		if ($flush)
		{
			$this->entityManager->flush($entity);
		}
	}

	/**
	 * @throws Exception
	 */
	public function flush()
	{
		$this->entityManager->flush();
	}
}