<?php

return [
	// Retrieve list of modules used in this application.
	'modules' => [
		'Zend\Router',
		'Common'
	],

	// These are various options for the listeners attached to the ModuleManager
	'module_listener_options' => [
		// This should be an array of paths in which modules reside.
		// If a string key is provided, the listener will consider that a module
		// namespace, the value of that key the specific path to that module's
		// Module class.
		'module_paths' => [
			'.',
			'./vendor'
		],

		// An array of paths from which to glob configuration files after
		// modules are loaded. These effectively override configuration
		// provided by modules themselves. Paths may use GLOB_BRACE notation.
		'config_glob_paths' => [
			realpath(__DIR__) . '/autoload/{{,*.}global,{,*.}local}.php',
		],

		// Whether or not to enable a configuration cache.
		// If enabled, the merged configuration will be cached and used in
		// subsequent requests.
		'config_cache_enabled' => false,

		// Whether or not to enable a module class map cache.
		// If enabled, creates a module class map cache which will be used
		// by in future requests, to reduce the autoloading process.
		'module_map_cache_enabled' => false,
	],
];
