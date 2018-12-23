<?php
namespace CommonTest\Util;

use Common\Util\StringUtil;
use CommonTest\Base;

class StringUtilStartsWithTest extends Base
{
	/**
	 * @dataProvider startsWithSet
	 * @param $string
	 * @param $startsWith
	 * @param $expectedResult
	 */
	public function test_starts_with($string, $startsWith, $expectedResult)
	{
		$this->assertEquals(
			$expectedResult,
			StringUtil::startsWith($string, $startsWith)
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
			[ 'test', 'testx', false ],
		];
	}
}