<?php
namespace Common\Db;

class FilterChain
{
	/**
	 * @var Filter[]
	 */
	private $filters = [];

	/**
	 * @return FilterChain
	 */
	public static function create()
	{
		return new self();
	}

	/**
	 * @param Filter $filter
	 * @return FilterChain
	 */
	public function addFilter(Filter $filter) : FilterChain
	{
		$this->filters[] = $filter;

		return $this;
	}

	/**
	 * @return Filter[]
	 */
	public function getFilters(): array
	{
		return $this->filters;
	}
}