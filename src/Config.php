<?php namespace Affinity
{
	use Dotink\Flourish;

	/**
	 *
	 */
	class Config implements ConfigInterface
	{
		/**
		 *
		 */
		static public function create($types, $data = NULL)
		{
			if (func_num_args() == 1) {
				$types    = [];
				$resource = func_get_arg(0);
			}

			return new static($types, $data);
		}


		/**
		 *
		 */
		public function __construct(Array $types, Array $data)
		{
			$this->types = array_unique($types);
			$this->data  = $data;
		}


		/**
		 *
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
		 *
		 */
		public function getData()
		{
			return $this->data;
		}


		/**
		 *
		 */
		public function getTypes()
		{
			return $this->types;
		}
	}
}