<?php
namespace CommonTest\RequestData;

use Common\RequestData\Data;
use Common\RequestData\PropertyDefinition\Email;

class EmailOptionalTest extends Base
{
	/**
	 * @return string
	 */
	protected function getField()
	{
		return 'email';
	}

	/**
	 * @return string
	 */
	protected function getDataClass()
	{
		return EmailOptionalTestData::class;
	}

	/**
	 * @return array
	 */
	public function myDataSet()
	{
		return [
			[ null, false, null ],
			[ '', true, null ],
			[ ' ', true, null ],
			[ 'test', true, null ],
			[ 'test@', true, null ],
			[ 'test@test', true, null ],
			[ 'test@test.at', false, 'test@test.at' ],
		];
	}
}

class EmailOptionalTestData extends Data
{
	protected function getDefinitions()
	{
		return [
			Email::create()
				->setName('email')
				->setRequired(false)
		];
	}
}