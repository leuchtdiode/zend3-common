<?php
namespace Common;

class DefaultFactory extends AbstractDefaultFactory
{
	/**
	 * @return string
	 */
	protected function getNamespace()
	{
		return __NAMESPACE__;
	}
}