<?php
namespace Common\Db;

use Doctrine\ORM\QueryBuilder;

interface Order
{
	public function addOrder(QueryBuilder $queryBuilder);
}