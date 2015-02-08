<?php namespace Affinity
{
	use Dotink\Flourish;

	/**
	 *
	 */
	class Engine
	{
		private $actions = array();

		private $configs = array();

		private $context = array();

		private $drivers = array();

		private $settled = array();


		/**
		 *
		 */
		public function __construct($config_driver, $action_driver)
		{
			$this->drivers['config'] = $config_driver;
			$this->drivers['action'] = $action_driver;
		}


		/**
		 *
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
		 *
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
		 *
		 */
		public function exec($callback)
		{
			return call_user_func_array($callback, $this->context);
		}


		/**
		 *
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
		 *
		 */
		public function start($environment, $context)
		{
			$this->context = $context;

			$this->drivers['config']->load($this, $environment, $context);
			$this->drivers['action']->load($this, $environment, $context);

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
		 *
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
