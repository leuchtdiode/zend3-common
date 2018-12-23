<?php
namespace CommonTest\RequestData;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Zend\Http\Request;
use Zend\Stdlib\Parameters;

abstract class Base extends TestCase
{
	abstract protected function getField();

	abstract protected function getDataClass();

	/**
	 * @dataProvider myDataSet
	 * @param $value
	 * @param $hasErrors
	 * @param $expectedValue
	 */
	public function test_values($value, $hasErrors, $expectedValue)
	{
		$dataClass = $this->getDataClass();

		$data = new $dataClass($this->getContainerMock());

		$requestData = [
			$this->getField() => $value
		];

		$values = $data
			->setRequest($this->getRequest($requestData))
			->getValues();

		$this->assertEquals($values->hasErrors(), $hasErrors);
		$this->assertEquals($expectedValue, $values->get($this->getField())->getValue());
	}

	/**
	 * @param $data
	 * @return Request
	 */
	protected function getRequest($data)
	{
		$request = new Request();
		$request->setQuery(
			new Parameters($data)
		);

		return $request;
	}

	/**
	 * @return MockObject|ContainerInterface
	 */
	protected function getContainerMock()
	{
		return $this
			->getMockBuilder(ContainerInterface::class)
			->getMock();
	}
}