<?php namespace Affinity
{
	use Dotink\Flourish;

	/**
	 *
	 */
	class Action implements ActionInterface
	{
		/**
		 *
		 */
		private $dependencies = [];


		/**
		 *
		 */
		private $operation = NULL;


		/**
		 *
		 */
		static public function create($dependencies, $operation = NULL)
		{
			if (func_num_args() == 1) {
				$dependencies = [];
				$operation    = func_get_arg(0);
			}

			return new static($dependencies, $operation);
		}


		/**
		 *
		 */
		public function __construct(Array $dependencies, callable $operation)
		{
			$this->dependencies = array_unique($dependencies);
			$this->operation    = $operation;
		}


		/**
		 *
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
		}


		/**
		 *
		 */
		public function getDependencies()
		{
			return $this->dependencies;
		}


		/**
		 *
		 */
		public function getOperation()
		{
			return $this->operation;
		}
	}
}