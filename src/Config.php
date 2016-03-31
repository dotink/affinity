<?php namespace Affinity
{
	/**
	 * The configuration class encapsulates configuration data
	 *
	 * @copyright Copyright (c) 2015, Matthew J. Sahagian
	 * @author Matthew J. Sahagian [mjs] <msahagian@dotink.org>
	 *
	 * @license Please reference the LICENSE.md file at the root of this distribution
	 *
	 * @package Affinity
	 */
	class Config implements ConfigInterface
	{
		/**
		 * The configuration data for this config
		 *
		 * @access private
		 * @var array
		 */
		private $data = array();


		/**
		 * The types of configuration data this config contains
		 *
		 * @access private
		 * @var array
		 */
		private $types = array();


		/**
		 * A simple factory method to create a new config
		 *
		 * @static
		 * @access public
		 * @param array $types The list of types in the configuration data
		 * @param array $data The configuration data
		 * @return Config The constructed configuration
		 */
		static public function create($types, array $data = NULL)
		{
			if (func_num_args() == 1) {
				$data  = func_get_arg(0);
				$types = array();
			}

			settype($types, 'array');

			return new static($types, $data);
		}


		/**
		 * Create a new config
		 *
		 * @access public
		 * @param array $types The list of types in the configuration data
		 * @param array $data The configuration data
		 * @return Config The constructed configuration
		 */
		public function __construct(array $types, array $data)
		{
			$this->types = array_unique($types);
			$this->data  = $data;
		}


		/**
		 * Extend a config by merging configuration data
		 *
		 * Note that this modifies the original config as opposed to creating a new config.
		 * The config returned will be the same one you called `extend()` on but will have a
		 * modified data and types.
		 *
		 * @access public
		 * @param ConfigInterface $config The config with which to extend this one
		 * @return Config the extended config
		 */
		public function extend(ConfigInterface $config)
		{
			$this->types = array_unique(array_merge(
				$this->getTypes(),
				$config->getTypes()
			));

			$this->data = array_replace_recursive(
				$this->getData(),
				$config->getData()
			);
		}


		/**
		 * Get the data for this config
		 *
		 * @access public
		 * @return array The data for this config
		 */
		public function getData()
		{
			return $this->data;
		}


		/**
		 * Get the types for this config
		 *
		 * @access public
		 * @return array The types for this config
		 */
		public function getTypes()
		{
			return $this->types;
		}
	}
}
