<?php namespace Affinity
{
	/**
	 * The public interface for a config
	 *
	 * @copyright Copyright (c) 2015, Matthew J. Sahagian
	 * @author Matthew J. Sahagian [mjs] <msahagian@dotink.org>
	 *
	 * @license Please reference the LICENSE.md file at the root of this distribution
	 *
	 * @package Affinity
	 */
	interface ConfigInterface
	{
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
		public function extend(ConfigInterface $config);


		/**
		 * Get the data for this config
		 *
		 * @access public
		 * @return array The data for this config
		 */
		public function getData();


		/**
		 * Get the types for this config
		 *
		 * @access public
		 * @return array The types for this config
		 */
		public function getTypes();
	}
}
