<?php
namespace Common\Db;

use Doctrine\ORM\EntityManager;
use Exception;

class EntitySaver
{
	/**
	 * @var EntityManager
	 */
	private $entityManager;

	/**
	 * @param EntityManager $entityManager
	 */
	public function __construct(EntityManager $entityManager)
	{
		$this->entityManager = $entityManager;
	}

	public function save($entity)
	{
		try
		{
			$this->entityManager->persist($entity);
			$this->entityManager->flush();

			return true;
		}
		catch (Exception $ex)
		{
			error_log($ex->getMessage());
		}

		return false;
	}
}