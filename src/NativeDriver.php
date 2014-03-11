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
		public function load($engine, $environment)
		{
			$this->engine = $engine;

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
				$res = include $target_file;
				$key = str_replace($base, '', $target_file);
				$key = pathinfo($key, PATHINFO_FILENAME);

				if ($res instanceof ConfigInterface) {
					$this->engine->addConfig($key, $res);
				} elseif ($res instanceof ActionInterface) {
					$this->engine->addAction($key, $res);
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
	}
}