<?php
namespace Common\Action;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;

abstract class BaseAction extends AbstractActionController
{
	/**
	 * @return JsonModel
	 */
	abstract public function executeAction();
}