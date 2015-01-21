<?php namespace Dotink\Lab
{
	use Affinity;

	return [

		'setup' => function($data, $shared)
		{
			needs($data['root'] . '/src/ConfigInterface.php');
			needs($data['root'] . '/src/Config.php');

			needs($data['root'] . '/src/ActionInterface.php');
			needs($data['root'] . '/src/Action.php');

			needs($data['root'] . '/src/DriverInterface.php');
			needs($data['root'] . '/src/NativeDriver.php');

			needs($data['root'] . '/src/Engine.php');

		},

		'tests' => [

			/**
			 *
			 */
			'Complete test with sample data' => function($data, $shared)
			{
				$config_driver = new Affinity\NativeDriver($data['root'] . '/tests/sample/config');
				$action_driver = new Affinity\NativeDriver($data['root'] . '/tests/sample/include');

				$engine = new Affinity\Engine($config_driver, $action_driver);
				$engine->start('dev', $engine);

				assert($engine->fetch('core',  'foo'))->equals('too');
				assert($engine->fetch('@test', 'foo'))->equals(['core' => 'bar']);
			}
		]
	];
}