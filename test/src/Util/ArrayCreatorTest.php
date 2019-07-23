<?php
namespace CommonTest\Util;

use Common\Util\ArrayCreator;
use CommonTest\Base;

class ArrayCreatorTest extends Base
{
	public function test_creation()
	{
		$arrayCreator = ArrayCreator::create()
			->addIfNotEmpty(null, 'null')
			->addIfNotEmpty(0, 'null-as-int')
			->addIfNotEmpty('', 'empty')
			->add('test', 'test')
			->addIfNotEmpty('test1', 'test1');

		$this->assertEquals(
			[
				'test'  => 'test',
				'test1' => 'test1',
			],
			$arrayCreator->getArray()
		);
	}

	public function test_creation_if_not_null()
	{
		$arrayCreator = ArrayCreator::create()
			->addIfNotNull(null, 'null')
			->addIfNotNull(0, 'null-as-int')
			->addIfNotNull('', 'empty')
			->add('test', 'test')
			->addIfNotNull('test1', 'test1');

		$this->assertEquals(
			[
				'null-as-int' => 0,
				'empty'       => '',
				'test'        => 'test',
				'test1'       => 'test1',
			],
			$arrayCreator->getArray()
		);
	}
}