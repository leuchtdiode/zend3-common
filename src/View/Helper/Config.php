<?php
namespace Common\View\Helper;

use Zend\View\Helper\AbstractHelper;

class Config extends AbstractHelper
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