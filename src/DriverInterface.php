<?php namespace Affinity
{
	/**
	 * The public interface for drivers
	 *
	 * The driver is responsible for adding configs and actions to the engine based on the
	 * provided environments and context.  These can be loaded from any source.  It is up to
	 * the driver to interface with the source and add actions or configs to the engine directly.
	 *
	 * @copyright Copyright (c) 2015, Matthew J. Sahagian
	 * @author Matthew J. Sahagian [mjs] <msahagian@dotink.org>
	 *
	 * @license Please reference the LICENSE.md file at the root of this distribution
	 *
	 * @package Affinity
	 */
	interface DriverInterface
	{
		/**
		 * Load actions and configs using the driver
		 *
		 * This should load the default environment in addition to environments provided in
		 * the `$environments` parameter.
		 *
		 * @access public
		 * @param Engine $engine The engine to which loaded configs/actions will be added
		 * @param array $environments A list of additional environments to load
		 * @param array $context The context to be made available when loading configs and actions
		 * @return void
		 */
		public function load(Engine $engine, array $environments, array $context);
	}
}
