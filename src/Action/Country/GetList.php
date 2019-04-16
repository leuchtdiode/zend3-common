<?php
namespace Common\Action\Country;

use Common\Action\BaseJsonAction;
use Common\Action\JsonResponse;
use Common\Country\Provider as CountryProvider;
use Common\Hydration\ObjectToArrayHydrator;
use Exception;
use Zend\View\Model\JsonModel;

class GetList extends BaseJsonAction
{
	/**
	 * @var CountryProvider
	 */
	private $countryProvider;

	/**
	 * @param CountryProvider $countryProvider
	 */
	public function __construct(CountryProvider $countryProvider)
	{
		$this->countryProvider = $countryProvider;
	}

	/**
	 * @return JsonModel
	 * @throws Exception
	 */
	public function executeAction()
	{
		return JsonResponse::is()
			->successful()
			->data(
				ObjectToArrayHydrator::hydrate(
					$this->countryProvider->all()
				)
			)
			->dispatch();
	}
}