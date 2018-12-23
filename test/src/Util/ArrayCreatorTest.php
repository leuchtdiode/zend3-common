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
}