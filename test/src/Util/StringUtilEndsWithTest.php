<?php
namespace CommonTest\Util;

use Common\Util\StringUtil;
use CommonTest\Base;

class StringUtilEndsWithTest extends Base
{
	/**
	 * @dataProvider startsWithSet
	 * @param $string
	 * @param $endsWith
	 * @param $expectedResult
	 */
	public function test_ends_with($string, $endsWith, $expectedResult)
	{
		$this->assertEquals(
			$expectedResult,
			StringUtil::endsWith($string, $endsWith)
		);
	}

	/**
	 * @return array
	 */
	public function startsWithSet()
	{
		return [
			[ 'test', 't', true ],
			[ 'test', 'x', false ],
			[ 'test', 'test', true ],
			[ 'test', 'est', true ],
			[ 'test', 'testx', false ],
		];
	}
}