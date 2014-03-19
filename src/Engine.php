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
						$result[] = $key;
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
		public function start($environment)
		{
			$this->context = array_slice(func_get_args(), 1);

			$this->drivers['config']->load($this, $environment);
			$this->drivers['action']->load($this, $environment);

			uksort($this->actions, function($a, $b) {
				if (in_array($a, $this->actions[$b]->getDependencies())) {
					return -1;
				} elseif (in_array($b, $this->actions[$a]->getDependencies())) {
					return 1;
				}

				return 0;
			});

			foreach ($this->actions as $key => $action) {
				$unsettled = array_diff($action->getDependencies(), $this->settled);

				if (count($unsettled)) {
					throw new Flourish\ProgrammerException (
						'Unsettled dependencies %s on action %s, this may indicate co-dependency',
						implode(', ', $unsettled),
						$key
					);
				}

				$this->exec($action->getOperation());

				$this->settled[] = $key;
			}
		}
	}
}