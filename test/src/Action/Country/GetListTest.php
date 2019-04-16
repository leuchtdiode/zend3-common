<?php
namespace CommonTest\Action\Country;

use Exception;
use CommonTest\Base;

class GetListTest extends Base
{
	/**
	 * @throws Exception
	 */
	public function test_correct_output()
	{
		$this->dispatch('/common/country');

		$response = $this->getResponse();

		$this->assertEquals(200, $response->getStatusCode());

		$this->assertJsonStringEqualsJsonFile(
			__DIR__ . '/get-list-response.json',
			$response->getContent()
		);
	}
}