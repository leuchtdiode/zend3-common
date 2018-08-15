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

	public function delete($entity)
	{
		try
		{
			$this->entityManager->remove($entity);
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