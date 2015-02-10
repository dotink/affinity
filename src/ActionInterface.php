<?php namespace Affinity
{
	/**
	 * The public interface for an action
	 *
	 * @copyright Copyright (c) 2015, Matthew J. Sahagian
	 * @author Matthew J. Sahagian [mjs] <msahagian@dotink.org>
	 *
	 * @license Please reference the LICENSE.md file at the root of this distribution
	 *
	 * @package Affinity
	 */
	interface ActionInterface
	{
		/**
		 * Extend an action by appending additional logic
		 *
		 * Note that this should modify the original action, not return a new one.
		 *
		 * @access public
		 * @param ActionInterface $action The action with which to extend this one
		 * @return Action the extended action
		 */
		public function extend(ActionInterface $action);


		/**
		 * Get the dependencies for this action
		 *
		 * @access public
		 * @return array The dependencies for the action
		 */
		public function getOperation();


		/**
		 * Get the operation for this action
		 *
		 * @access public
		 * @return callable The operation for this action
		 */
		public function getDependencies();
	}
}
