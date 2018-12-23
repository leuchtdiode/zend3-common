<?php
namespace CommonTest\Router;

use Common\Router\BaseUrlProvider;
use Exception;
use CommonTest\Base;

class BaseUrlProviderTeste extends Base
{
	/**
	 * @expectedException Exception
	 */
	public function test_missing_config_throws_exception()
	{
		(new BaseUrlProvider([]))->get();
	}

	/**
	 * @throws Exception
	 */
	public function test_bae_url()
	{
		$config = [
			'common' => [
				'url' => [
					'protocol' => 'https',
					'host'     => 'try2catch.com',
				],
			],
		];

		$this->assertEquals(
			'https://try2catch.com',
			(new BaseUrlProvider($config))
				->get()
		);
	}
}