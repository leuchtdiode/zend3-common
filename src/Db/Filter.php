<?php
namespace Common\Db;

use Doctrine\ORM\QueryBuilder;

interface Filter
{
	public function addClause(QueryBuilder $queryBuilder);
}