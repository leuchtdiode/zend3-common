<?php
namespace Common;

use Common\View\Helper\StaticResource;
use Common\View\Helper\StaticResourceFactory;

return [

	'view_helpers' => [
		'factories' => [
			StaticResource::class => StaticResourceFactory::class,
		],
		'aliases' => [
			'staticResource' => StaticResource::class
		],
	],

	'service_manager'  => [
		'abstract_factories' => [
			DefaultFactory::class
		],
	],
];