<?php
namespace CommonTest\Util;

use Common\Util\StringUtil;
use CommonTest\Base;

class StringUtilTest extends Base
{
	/**
	 * @dataProvider containsSet
	 * @param $string
	 * @param $containing
	 * @param $contains
	 */
	public function test_contains($string, $containing, $contains)
	{
		$this->assertEquals(
			$contains,
			StringUtil::contains($string, $containing)
		);
	}

	/**
	 * @return array
	 */
	public function containsSet()
	{
		return [
			[ 'test', 't', true ],
			[ 'test', 'test', true ],
			[ 'test', 'testx', false ],
			[ 'test', 'x', false ],
			[ 'test xxx', 'xxx', true ],
			[ 'töst', 'ö', true ],
		];
	}
}