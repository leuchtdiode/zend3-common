<?php

use Common\Action\Country\GetList;
use Common\Router\HttpRouteCreator;

return HttpRouteCreator::create()
	->setRoute('/country')
	->setAction(GetList::class)
	->getConfig();