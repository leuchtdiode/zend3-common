<?php
namespace Common\Action;

use Common\Error;
use Common\Hydration\ObjectToArrayHydrator;
use Exception;
use Zend\View\Model\JsonModel;

class JsonResponse
{
	/**
	 * @var bool
	 */
	private $success;

	/**
	 * @var Error[]
	 */
	private $errors = [];

	/**
	 * @var array
	 */
	private $data;

	/**
	 * @return JsonResponse
	 */
	public static function is()
	{
		return new self();
	}

	/**
	 * @return JsonModel
	 * @throws Exception
	 */
	public function dispatch()
	{
		return new JsonModel(
			[
				'success' => $this->success,
				'data'    => $this->data,
				'errors'  => ObjectToArrayHydrator::hydrate($this->errors),
			]
		);
	}

	/**
	 * @return JsonResponse
	 */
	public function successful(): JsonResponse
	{
		$this->success = true;

		return $this;
	}

	/**
	 * @return JsonResponse
	 */
	public function unsuccessful(): JsonResponse
	{
		$this->success = false;

		return $this;
	}

	/**
	 * @param Error[] $errors
	 * @return JsonResponse
	 */
	public function errors(array $errors): JsonResponse
	{
		$this->errors = $errors;

		return $this;
	}

	/**
	 * @param array $data
	 * @return JsonResponse
	 */
	public function data(array $data): JsonResponse
	{
		$this->data = $data;

		return $this;
	}
}