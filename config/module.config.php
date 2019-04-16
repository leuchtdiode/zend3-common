<?php
namespace Common;

use Common\Action\Plugin\Config as ConfigActionPlugin;
use Common\Action\Plugin\ConfigFactory as ConfigActionPluginFactory;
use Common\Router\HttpRouteCreator;
use Common\View\Helper\AbsoluteUrl;
use Common\View\Helper\AbsoluteUrlFactory;
use Common\View\Helper\Config;
use Common\View\Helper\ConfigFactory;
use Common\View\Helper\StaticResource;
use Common\View\Helper\StaticResourceFactory;

return [

	'common' => [
		'translator' => [
			'global' => [
				'enabled' => true,
			],
		],
	],

	'router' => [
		'routes' => [
			'common' => HttpRouteCreator::create()
				->setRoute('/common')
				->setChildRoutes(
					[
						'country' => require 'routes/country.php'
					]
				)
				->getConfig(),
		],
	],

	'view_helpers' => [
		'factories' => [
			StaticResource::class => StaticResourceFactory::class,
			AbsoluteUrl::class    => AbsoluteUrlFactory::class,
			Config::class         => ConfigFactory::class,
		],
		'aliases'   => [
			'staticResource' => StaticResource::class,
			'absoluteUrl'    => AbsoluteUrl::class,
			'config'         => Config::class,
		],
	],

	'controller_plugins' => [
		'factories' => [
			ConfigActionPlugin::class => ConfigActionPluginFactory::class,
		],
		'aliases'   => [
			'config' => ConfigActionPlugin::class,
		],
	],

	'service_manager' => [
		'abstract_factories' => [
			DefaultFactory::class,
		],
	],

	'controllers' => [
		'abstract_factories' => [
			DefaultFactory::class,
		],
	],

	'view_manager' => [
		'strategies'   => [
			'ViewJsonStrategy',
		],
	],
];