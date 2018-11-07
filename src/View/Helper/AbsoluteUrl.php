<?php
namespace Common\View\Helper;

use Common\Router\BaseUrlProvider;
use Zend\View\Helper\AbstractHelper;

class AbsoluteUrl extends AbstractHelper
{
	/**
	 * @var BaseUrlProvider
	 */
	private $baseUrlProvider;

	/**
	 * @param BaseUrlProvider $baseUrlProvider
	 */
	public function __construct(BaseUrlProvider $baseUrlProvider)
	{
		$this->baseUrlProvider = $baseUrlProvider;
	}

	/**
	* @param string $requestUri
	* @return string
	*/
	public function __invoke($requestUri = '')
	{
		if (strpos($requestUri, '/') === 0)
		{
			$requestUri = substr($requestUri, 1);
		}

		return sprintf(
			'%s/%s',
			$this->baseUrlProvider->get(),
			$requestUri
		);
	}
}