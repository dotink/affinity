<?php namespace Affinity
{
	use Dotink\Flourish;

	/**
	 *
	 */
	class NativeDriver implements DriverInterface
	{
		/**
		 *
		 */
		private $directory = NULL;


		/**
		 *
		 */
		public function __construct($directory)
		{
			$this->directory = realpath($directory);

			if ($this->directory === FALSE || !is_dir($this->directory)) {
				throw new Flourish\EnvironmentException(
					'The directory %s could not be found or is not a directory',
					$directory
				);
			}

			$this->directory = rtrim($this->directory, '/\\' . DIRECTORY_SEPARATOR);
		}


		/**
		 *
		 */
		public function load($engine, $environment, $context)
		{
			$this->engine  = $engine;
			$this->context = $context;

			if ($environment != 'default') {
				$this->scanDirectory($this->directory . DIRECTORY_SEPARATOR . 'default');
			}

			$this->scanDirectory($this->directory . DIRECTORY_SEPARATOR . $environment);
		}


		/**
		 *
		 */
		protected function scanDirectory($directory, $base = NULL)
		{
			$base            = $base ?: $directory;
			$target_files    = glob($directory . DIRECTORY_SEPARATOR . '*.php');
			$sub_directories = glob($directory . DIRECTORY_SEPARATOR . '*', GLOB_ONLYDIR);

			foreach ($target_files as $target_file) {
				$result   = $this->retrieve($target_file);
				$key_path = sprintf(
					'%s' . DIRECTORY_SEPARATOR . '%s',
					str_replace($base, '', $directory),
					pathinfo($target_file, PATHINFO_FILENAME)
				);

				if ($result instanceof ConfigInterface) {
					$this->engine->addConfig(trim($key_path, DIRECTORY_SEPARATOR), $result);
				} elseif ($result instanceof ActionInterface) {
					$this->engine->addAction(trim($key_path, DIRECTORY_SEPARATOR), $result);
				} else {
					throw new Flourish\ProgrammerException(
						'Invalid affinity result loaded from %s',
						$target_file
					);
				}
			}

			foreach ($sub_directories as $sub_directory) {
				$this->scanDirectory($sub_directory, $base);
			}
		}
		
		
		/**
		 *
		 */
		protected function retrieve($target_file)
		{
			extract($this->context, EXTR_SKIP);
			
			return include $target_file;			
		}
	}
}
