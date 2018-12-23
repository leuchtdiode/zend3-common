<?php
namespace CommonTest\RequestData;

use Common\RequestData\Data;
use Common\RequestData\PropertyDefinition\Uuid as UuidPropertyDefinition;

class Uuid extends Base
{
	/**
	 * @return string
	 */
	protected function getField()
	{
		return 'id';
	}

	/**
	 * @return string
	 */
	protected function getDataClass()
	{
		return UuidTestData::class;
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
			[ 'aab9d877-1b2b-4dc5-b6da-40a1f5aa98d1x', true, null ],
			[ 'aab9d877-1b2b-4dc5-b6da-40a1f5aa98d1', false, 'aab9d877-1b2b-4dc5-b6da-40a1f5aa98d1' ],
		];
	}
}

class UuidTestData extends Data
{
	protected function getDefinitions()
	{
		return [
			UuidPropertyDefinition::create()
				->setName('id')
				->setRequired(true),
		];
	}
}