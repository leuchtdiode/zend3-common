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
	 * @return bool
	 */
	public function save($entity, $flush = true)
	{
		try
		{
			$this->entityManager->persist($entity);

			if ($flush)
			{
				$this->entityManager->flush();
			}

			return true;
		}
		catch (Exception $ex)
		{
			error_log($ex->getMessage());
		}

		return false;
	}

	/**
	 * @return bool
	 */
	public function flush()
	{
		try
		{
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