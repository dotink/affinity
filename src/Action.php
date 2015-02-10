<?php namespace Affinity
{
	/**
	 * The action class encapsulates an operation and dependencies for the operation
	 *
	 * @copyright Copyright (c) 2015, Matthew J. Sahagian
	 * @author Matthew J. Sahagian [mjs] <msahagian@dotink.org>
	 *
	 * @license Please reference the LICENSE.md file at the root of this distribution
	 *
	 * @package Affinity
	 */
	class Action implements ActionInterface
	{
		/**
		 * The dependency requirements for this action
		 *
		 * @access private
		 * @var array
		 */
		private $dependencies = array();


		/**
		 * The operation to perform when the action is executed
		 *
		 * @access private
		 * @var callable
		 */
		private $operation = NULL;


		/**
		 * A simple factory method to create a new action
		 *
		 * @static
		 * @access public
		 * @param array $dependencies The list of dependencies for this action
		 * @param callable $operation The operation to perform when the action is executed
		 * @return Action The constructed action
		 */
		static public function create($dependencies, callable $operation = NULL)
		{
			if (func_num_args() == 1) {
				$dependencies = array();
				$operation    = func_get_arg(0);
			}

			settype($dependencies, 'array');

			return new static($dependencies, $operation);
		}


		/**
		 * Create a new action
		 *
		 * @access public
		 * @param array $dependencies The list of dependencies for this action
		 * @param callable $operation The operation to perform when the action is executed
		 * @return void
		 */
		public function __construct(array $dependencies, callable $operation)
		{
			$this->dependencies = array_unique($dependencies);
			$this->operation    = $operation;
		}


		/**
		 * Extend an action by appending additional logic
		 *
		 * Note that this modifies the original action as opposed to creating a new action.
		 * The action returned will be the same one you called `extend()` on but will have a
		 * modified operation and dependencies.
		 *
		 * @access public
		 * @param ActionInterface $action The action with which to extend this one
		 * @return Action the extended action
		 */
		public function extend(ActionInterface $action)
		{
			$principal = $this->getOperation();
			$extension = $action->getOperation();

			$this->dependencies = array_unique(array_merge(
				$this->getDependencies(),
				$action->getDependencies()
			));

			$this->operation = function() use ($principal, $extension) {
				call_user_func_array($principal, func_get_args());
				call_user_func_array($extension, func_get_args());
			};

			return $this;
		}


		/**
		 * Get the dependencies for this action
		 *
		 * @access public
		 * @return array The dependencies for the action
		 */
		public function getDependencies()
		{
			return $this->dependencies;
		}


		/**
		 * Get the operation for this action
		 *
		 * @access public
		 * @return callable The operation for this action
		 */
		public function getOperation()
		{
			return $this->operation;
		}
	}
}
