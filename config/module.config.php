<?php
namespace Common;

use Common\Action\Plugin\Config as ConfigActionPlugin;
use Common\Action\Plugin\ConfigFactory as ConfigActionPluginFactory;
use Common\View\Helper\AbsoluteUrl;
use Common\View\Helper\AbsoluteUrlFactory;
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

	'controller_plugins' => [
		'factories' => [
			ConfigActionPlugin::class => ConfigActionPluginFactory::class
		],
		'aliases'   => [
			'config' => ConfigActionPlugin::class
		],
	],

	'service_manager' => [
		'abstract_factories' => [
			DefaultFactory::class,
		],
	],
];