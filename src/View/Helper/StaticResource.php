<?php
namespace Common\View\Helper;

use Zend\View\Helper\AbstractHelper;

class StaticResource extends AbstractHelper
{
	const NAME = 'staticResource';

	/**
	 * @var string
	 */
	private $basePath;

	/**
	 * @param string $basePath
	 */
	public function __construct($basePath)
	{
		$this->basePath = $basePath;
	}

	/**
	 * @param string $resource
	 * @return string
	 */
	public function __invoke($resource)
	{
		$file = $this->basePath . DIRECTORY_SEPARATOR . $resource;
		
		$pathInfo = pathinfo($file);
		
		return sprintf(
			'%s/%s__%s.%s',
			str_replace($this->basePath, '', $pathInfo['dirname']),
			$pathInfo['filename'],
			filemtime($file),
			$pathInfo['extension']
		);
	}
}