<?php
namespace CommonTest\RequestData;

use Common\RequestData\Data;
use Common\RequestData\PropertyDefinition\Date;

class DateTest extends Base
{
	/**
	 * @return string
	 */
	protected function getField()
	{
		return 'date';
	}

	/**
	 * @return string
	 */
	protected function getDataClass()
	{
		return DateTestData::class;
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
			[ '2018', true, null ],
			[ '2018-12-32', true, null ],
			[ '23.12.2018', true, null ],
			[ '2018-12-32 12:00:00', true, null ],
			[ '2018-12-23', false, '2018-12-23' ],
		];
	}
}

class DateTestData extends Data
{
	protected function getDefinitions()
	{
		return [
			Date::create()
				->setName('date')
				->setRequired(true),
		];
	}
}