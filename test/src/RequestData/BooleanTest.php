<?php
namespace CommonTest\RequestData;

use Common\RequestData\Data;
use Common\RequestData\PropertyDefinition\Boolean;

class BooleanTest extends Base
{
	/**
	 * @return string
	 */
	protected function getField()
	{
		return 'active';
	}

	/**
	 * @return string
	 */
	protected function getDataClass()
	{
		return BooleanTestData::class;
	}

	/**
	 * @return array
	 */
	public function myDataSet()
	{
		return [
			[ null, true, null ],
			[ '', true, null ],
			[ ' ', true, null ],
			[ 'test', true, null ],
			[ '1', false, true ],
			[ 1, false, true ],
			[ true, false, true ],
			[ '0', false, false ],
			[ 0, false, false ],
			[ false, false, false ],
		];
	}
}

class BooleanTestData extends Data
{
	protected function getDefinitions()
	{
		return [
			Boolean::create()
				->setName('active')
				->setRequired(true),
		];
	}
}