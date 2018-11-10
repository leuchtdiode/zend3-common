<?php
namespace Common\Action\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;

class Config extends AbstractPlugin
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
	 * @return array
	 */
	public function __invoke()
	{
		return $this->config;
	}
}