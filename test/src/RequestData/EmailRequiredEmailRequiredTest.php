<?php
namespace CommonTest\RequestData;

use Common\RequestData\Data;
use Common\RequestData\PropertyDefinition\Email;

class EmailRequiredTest extends Base
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
		return EmailRequiredTestData::class;
	}

	/**
	 * @return array
	 */
	public function myDataSet()
	{
		return [
			[ null, true ],
			[ '', true ],
			[ ' ', true ],
			[ 'test', true ],
			[ 'test@', true ],
			[ 'test@test', true ],
			[ 'test@test.at', false ],
		];
	}
}

class EmailRequiredTestData extends Data
{
	protected function getDefinitions()
	{
		return [
			Email::create()
				->setName('email')
				->setRequired(true)
		];
	}
}