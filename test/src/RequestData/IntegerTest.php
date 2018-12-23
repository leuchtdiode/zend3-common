<?php
namespace CommonTest\RequestData;

use Common\RequestData\Data;
use Common\RequestData\PropertyDefinition\Boolean;
use Common\RequestData\PropertyDefinition\Integer;

class IntegerTest extends Base
{
	/**
	 * @return string
	 */
	protected function getField()
	{
		return 'amount';
	}

	/**
	 * @return string
	 */
	protected function getDataClass()
	{
		return IntegerTestData::class;
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
			[ '0', false, 0 ],
			[ '1', false, 1 ],
			[ -10, true, null ],
			[ 0, false, 0 ],
			[ 1, false, 1 ],
			[ PHP_INT_MAX, false, PHP_INT_MAX ],
		];
	}
}

class IntegerTestData extends Data
{
	protected function getDefinitions()
	{
		return [
			Integer::create()
				->setName('amount')
				->setRequired(true),
		];
	}
}