<?php
namespace CommonTest\RequestData;

use Common\RequestData\Data;
use Common\RequestData\PropertyDefinition\Text;
use CommonTest\Base as CommonBase;
use Exception;
use Zend\Validator\StringLength;

class NestedObjectTest extends CommonBase
{
	/**
	 * @throws Exception
	 */
	public function test_all_filled_if_set()
	{
		$data = new NestedObjectTestData($this->getApplicationServiceLocator());
		$data->setData(
			[
				'name'     => 'test',
				'location' => [
					'zip'    => '1010',
					'city'   => 'Wien',
					'street' => 'Kärntner Straße 1',
				]
			]
		);

		$values = $data->getValues();

		$this->assertEquals('test', $values->get('name')->getValue());
		$this->assertEquals('1010', $values->get('location.zip')->getValue());
		$this->assertEquals('Wien', $values->get('location.city')->getValue());
		$this->assertEquals('Kärntner Straße 1', $values->get('location.street')->getValue());
	}

	/**
	 * @throws Exception
	 */
	public function test_errors_on_missing_nested_property()
	{
		$data = new NestedObjectTestData($this->getApplicationServiceLocator());
		$data->setData(
			[
				'name' => 'test',
			]
		);

		$values = $data->getValues();

		$this->assertTrue($values->hasErrors());

		$errors = $values->getErrors();

		$this->assertCount(3, $errors);
		$this->assertEquals('MANDATORY_PROPERTY_MISSING', $errors[0]->getCode());
		$this->assertEquals('MANDATORY_PROPERTY_MISSING', $errors[1]->getCode());
		$this->assertEquals('MANDATORY_PROPERTY_MISSING', $errors[2]->getCode());
	}

	/**
	 * @throws Exception
	 */
	public function test_error_on_incorrect_nested_property()
	{
		$data = new NestedObjectTestData($this->getApplicationServiceLocator());
		$data->setData(
			[
				'name'     => 'test',
				'location' => [
					'zip'    => '10101',
					'city'   => 'Wien',
					'street' => 'Kärntner Straße 1',
				]
			]
		);

		$values = $data->getValues();

		$this->assertTrue($values->hasErrors());

		$errors = $values->getErrors();

		$this->assertCount(1, $errors);
		$this->assertEquals('PROPERTY_INVALID', $errors[0]->getCode());
	}
}

class NestedObjectTestData extends Data
{
	protected function getDefinitions()
	{
		$zipValidator = new StringLength([ 'min' => 4, 'max' => 4 ]);

		return [
			Text::create()
				->setName('name')
				->setRequired(true),
			Text::create()
				->setName('location.zip')
				->setRequired(true)
				->addValidator(
					$zipValidator
				),
			Text::create()
				->setName('location.city')
				->setRequired(true),
			Text::create()
				->setName('location.street')
				->setRequired(true),
		];
	}
}