<?php
namespace Common\Router;

use Exception;

class BaseUrlProvider
{
	/**
	 * @var array
	 */
	private $config;

	/**
	 * @param array $config
	 */
	public function __construct(array $config)
	{
		$this->config = $config;
	}

	/**
	 * @return string
	 */
	public function get()
	{
		$config = $this->config['common']['url'];
		
		if (!$config)
		{
			throw new Exception('Could not find "url" config');
		}

		return sprintf(
			'%s://%s',
			$config['protocol'],
			$config['host']
		);
	}
}