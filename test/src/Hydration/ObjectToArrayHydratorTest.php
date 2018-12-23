<?php
namespace CommonTest\Hydration;

use Exception;
use Common\Hydration\ArrayHydratable;
use Common\Hydration\ObjectToArrayHydrator;
use CommonTest\Base;

class ObjectToArrayHydratorTest extends Base
{
	/**
	 * @throws Exception
	 */
	public function test_hydration()
	{
		$user = new User(
			1,
			'Alex',
			new Address('1010', true)
		);

		$this->assertEquals(
			[
				'id'      => 1,
				'name'    => 'Alex',
				'address' => [
					'zip'     => '1010',
					'default' => true,
				],
			],
			ObjectToArrayHydrator::hydrate($user)
		);
	}
}

class User implements ArrayHydratable
{
	/**
	 * @ObjectToArrayHydratorProperty
	 *
	 * @var int
	 */
	private $id;

	/**
	 * @ObjectToArrayHydratorProperty
	 *
	 * @var string
	 */
	private $name;

	/**
	 * @ObjectToArrayHydratorProperty
	 *
	 * @var Address
	 */
	private $address;

	/**
	 * @param int $id
	 * @param string $name
	 * @param Address $address
	 */
	public function __construct(int $id, string $name, Address $address)
	{
		$this->id      = $id;
		$this->name    = $name;
		$this->address = $address;
	}

	/**
	 * @return int
	 */
	public function getId(): int
	{
		return $this->id;
	}

	/**
	 * @return string
	 */
	public function getName(): string
	{
		return $this->name;
	}

	/**
	 * @return Address
	 */
	public function getAddress(): Address
	{
		return $this->address;
	}
}

class Address implements ArrayHydratable
{
	/**
	 * @var string
	 */
	private $zip;

	/**
	 * @var bool
	 */
	private $default;

	/**
	 * @param string $zip
	 * @param bool $default
	 */
	public function __construct(string $zip, bool $default)
	{
		$this->zip     = $zip;
		$this->default = $default;
	}

	/**
	 * @ObjectToArrayHydratorProperty
	 *
	 * @return string
	 */
	public function getZip(): string
	{
		return $this->zip;
	}

	/**
	 * @ObjectToArrayHydratorProperty
	 *
	 * @return bool
	 */
	public function isDefault(): bool
	{
		return $this->default;
	}
}