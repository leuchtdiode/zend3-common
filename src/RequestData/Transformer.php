<?php
namespace Common\RequestData;

interface Transformer
{
	/**
	 * @param mixed $value
	 * @return mixed
	 */
	public function transform($value);
}