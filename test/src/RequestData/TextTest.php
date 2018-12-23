<?php
namespace CommonTest\RequestData;

use Common\RequestData\Data;
use Common\RequestData\PropertyDefinition\Text;

class TextTest extends Base
{
	/**
	 * @return string
	 */
	protected function getField()
	{
		return 'irrelevant';
	}

	/**
	 * @return string
	 */
	protected function getDataClass()
	{
		return TextTestData::class;
	}

	/**
	 * @return array
	 */
	public function myDataSet()
	{
		return [
			[ null, true, null ],
			[ '', true, null ],
			[ ' ', false, ' ' ],
			[ 'test', false, 'test' ],
			[ "ich bin ein test\nmit linebreak", false, "ich bin ein test\nmit linebreak" ],
		];
	}
}

class TextTestData extends Data
{
	protected function getDefinitions()
	{
		return [
			Text::create()
				->setName('irrelevant')
				->setRequired(true),
		];
	}
}