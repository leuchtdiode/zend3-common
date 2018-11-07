<?php
namespace Common;

use Common\View\Helper\AbsoluteUrl;
use Common\View\Helper\AbsoluteUrlFactory;
use Common\View\Helper\StaticResource;
use Common\View\Helper\StaticResourceFactory;

return [

	'view_helpers' => [
		'factories' => [
			StaticResource::class => StaticResourceFactory::class,
			AbsoluteUrl::class    => AbsoluteUrlFactory::class,
		],
		'aliases'   => [
			'staticResource' => StaticResource::class,
			'absoluteUrl'    => AbsoluteUrl::class,
		],
	],

	'service_manager' => [
		'abstract_factories' => [
			DefaultFactory::class,
		],
	],
];