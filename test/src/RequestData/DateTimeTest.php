<?php
namespace CommonTest\RequestData;

use Common\RequestData\Data;
use Common\RequestData\PropertyDefinition\DateTime;

class DateTimeTest extends Base
{
	/**
	 * @return string
	 */
	protected function getField()
	{
		return 'datetime';
	}

	/**
	 * @return string
	 */
	protected function getDataClass()
	{
		return DateTimeTestData::class;
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
			[ '23.12.2018 12:00:00', true, null ],
			[ '23.12.2018 25:00:00', true, null ],
			[ '2018-12-32 00:00:00', true, null ],
			[ '2018-12-31 00:00:00', false, '2018-12-31 00:00:00' ],
			[ '2018-12-31 12:00:00', false, '2018-12-31 12:00:00' ],
			[ '2018-12-31 23:59:59', false, '2018-12-31 23:59:59' ],
		];
	}
}

class DateTimeTestData extends Data
{
	protected function getDefinitions()
	{
		return [
			DateTime::create()
				->setName('datetime')
				->setRequired(true),
		];
	}
}