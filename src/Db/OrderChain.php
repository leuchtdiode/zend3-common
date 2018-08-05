<?php
namespace Common\Db;

class OrderChain
{
	/**
	 * @var Order[]
	 */
	private $orders = [];

	/**
	 * @return OrderChain
	 */
	public static function create()
	{
		return new self();
	}

	/**
	 * @param Order $order
	 * @return OrderChain
	 */
	public function addOrder(Order $order) : OrderChain
	{
		$this->orders[] = $order;

		return $this;
	}

	/**
	 * @return Order[]
	 */
	public function getOrders(): array
	{
		return $this->orders;
	}
}