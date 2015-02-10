<?php namespace Affinity
{
	use Dotink\Flourish;

	/**
	 * The engine is responsible for executing all bootstrap logic and providing access to configs
	 *
	 * @copyright Copyright (c) 2015, Matthew J. Sahagian
	 * @author Matthew J. Sahagian [mjs] <msahagian@dotink.org>
	 *
	 * @license Please reference the LICENSE.md file at the root of this distribution
	 *
	 * @package Affinity
	 */
	class Engine
	{
		/**
		 * The actions registered for the engine
		 *
		 * @access private
		 * @var array
		 */
		private $actions = array();


		/**
		 * The configs registered for the engine
		 *
		 * @access private
		 * @var array
		 */
		private $configs = array();


		/**
		 * The context registered for the engine
		 *
		 * @access private
		 * @var array
		 */
		private $context = array();


		/**
		 * The drivers registered for the engine
		 *
		 * @access private
		 * @var array
		 */
		private $drivers = array();


		/**
		 * Dependencies which have already been settled
		 *
		 * @access private
		 * @var array
		 */
		private $settled = array();


		/**
		 * Create a new engine with any number of drivers
		 *
		 * @access public
		 * @param DriverInterface $driver A driver for loading actions / configs
		 * @param ...
		 * @return void
		 */
		public function __construct($drivers)
		{
			$this->drivers = func_get_args();
		}


		/**
		 * Add an action to the engine under a specific key ID
		 *
		 * @access public
		 * @param string $key The specific key ID
		 * @param ActionInterface $action The action to add
		 * @return void
		 */
		public function addAction($key, ActionInterface $action)
		{
			if (!isset($this->actions[$key])) {
				$this->actions[$key] = $action;
			} else {
				$this->actions[$key]->extend($action);
			}
		}


		/**
		 * Add a config to the engine under a specific key ID
		 *
		 * @access public
		 * @param string $key The specific key ID
		 * @param ConfigInterface $config The config to add
		 * @return void
		 */
		public function addConfig($key, ConfigInterface $config)
		{
			if (!isset($this->configs[$key])) {
				$this->configs[$key] = $config;
			} else {
				$this->configs[$key]->extend($config);
			}
		}


		/**
		 * Execute a provide action operation
		 *
		 * @access public
		 * @param callable $callback The callback for the operation
		 * @return mixed The result of the operation
		 */
		public function exec(callable $callback)
		{
			return call_user_func_array($callback, $this->context);
		}


		/**
		 * Fetch a specific key ID or aggregate ID's configuration values
		 *
		 * The param can be a string formatted as a JS object (example.property) which will
		 * resolve subparameters.  If a default is provided that will be returned if the value
		 * does not exist, NULL will be returned otherwise.
		 *
		 * In the case of aggregate IDs, the returned value will be an array.  If no parameter
		 * is specified the array will contain the specific key IDs for configs which contain
		 * the aggregate type.  Otherwise, the data will be the value of the array and the key
		 * will be the specific ID.
		 *
		 * @access public
		 * @param string $id The config ID to fetch, aggregate IDs are preceded with `@`
		 * @param string $param The param to fetch, can be JS style object notation
		 * @param mixed $default The default value if not found, `NULL` is the default default
		 * @return mixed The resolved configuration value
		 */
		public function fetch($id, $param = NULL, $default = NULL)
		{
			if ($id[0] === '@') {
				$result = array();
				$type   = substr($id, 1);

				if ($param === NULL) {
					foreach ($this->configs as $key => $config) {
						if (in_array($type, $config->getTypes())) {
							$result[] = $key;
						}
					}

				} else {
					foreach ($this->configs as $key => $config) {
						if (in_array($type, $config->getTypes())) {
							$result[$key] = $this->fetch($key, $id . '.' . $param, $default);
						}
					}
				}

			} else {
				if (!isset($this->configs[$id])) {
					throw new Flourish\ProgrammerException(
						'Cannot fetch from invalid configuration %s',
						$id
					);
				}

				$result = $this->configs[$id]->getData();

				if ($param !== NULL) {
					foreach(explode('.', $param) as $key) {
						if (isset($result[$key])) {
							$result = $result[$key];

						} else {
							$result = $default;
							break;
						}
					}
				}
			}

			return $result;
		}


		/**
		 * Start the engine for given environments and context
		 *
		 * @access public
		 * @param string $environments A comma separated list of non-default environments to load
		 * @param array $context The context to provide drivers and pass to operations
		 * @return void
		 */
		public function start($environments, array $context)
		{
			foreach ($this->drivers as $driver) {
				if (!($driver instanceof DriverInterface)) {
					throw new Flourish\ProgrammerException(
						'Invalid driver "%s" passed to engine, does not implement DriverInterface',
						print_r($driver, TRUE)
					);
				}

				$driver->load($this, array_map('trim', explode(',', $environments)), $context);
			}

			$this->context  = $context;
			$dependency_map = array();

			foreach ($this->actions as $key => $action) {
				$dependency_map[$key] = array();

				foreach ($action->getDependencies() as $sub_key) {
					$dependency_map = $this->mapChildDependencies($key, $sub_key, $dependency_map);
				}
			}

			uksort($dependency_map, function($a, $b) use ($dependency_map) {
				if (in_array($a, $dependency_map[$b])) {
					return -1;
				}

				if (in_array($b, $dependency_map[$a])) {
					return 1;
				}

				$diff_a = array_diff($dependency_map[$b], $dependency_map[$a]);
				$diff_b = array_diff($dependency_map[$a], $dependency_map[$b]);

				if (count($diff_b) > count($diff_a)) {
					return 1;
				}

				if (count($diff_a) > count($diff_b)) {
					return -1;
				}

				return 0;
			});

			foreach (array_keys($dependency_map) as $key) {
				$unsettled = array_diff($dependency_map[$key], $this->settled);

				if (count($unsettled)) {
					throw new Flourish\ProgrammerException (
						'Unsettled dependencies %s on action %s, this may indicate co-dependency',
						implode(', ', $unsettled),
						$key
					);
				}

				$this->exec($this->actions[$key]->getOperation());

				$this->settled[] = $key;
			}
		}


		/**
		 * Map all child dependencies for a given action key
		 *
		 * @access private
		 * @param string $key The key for the action whose dependencies we're mapping
		 * @param string $sub_key The child key we're mapping
		 * @param array $map The original dependency map
		 * @return array The new dependency map with child dependencies expanded
		 */
		private function mapChildDependencies($key, $sub_key, $map) {
			$map[$key][] = $sub_key;
			$sub_keys    = $this->actions[$sub_key]->getDependencies();

			if ($new_keys = array_diff($sub_keys, $map[$key])) {
				foreach ($new_keys as $new_key) {
					$map = $this->mapChildDependencies($key, $new_key, $map);
				}
			}

			return $map;
		}
	}
}
