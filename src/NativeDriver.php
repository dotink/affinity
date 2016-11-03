<?php namespace Affinity
{
	use Closure;
	use Dotink\Flourish;

	/**
	 * A native filesystem driver
	 *
	 * @copyright Copyright (c) 2015, Matthew J. Sahagian
	 * @author Matthew J. Sahagian [mjs] <msahagian@dotink.org>
	 *
	 * @license Please reference the LICENSE.md file at the root of this distribution
	 *
	 * @package Affinity
	 */
	class NativeDriver implements DriverInterface
	{
		/**
		 * The directory to load from
		 *
		 * @access private
		 * @var string
		 */
		private $directory = NULL;


		/**
		 * Create a new driver
		 *
		 * @access public
		 * @param string $directory The directory to load from (will load recursively)
		 * @return void
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
		 * Load actions and configs using the driver
		 *
		 * This should load the default environment in addition to environments provided in
		 * the `$environments` parameter.
		 *
		 * @access public
		 * @param Engine $engine The engine to which loaded configs/actions will be added
		 * @param string $environments A comma separated list of additional environments to load
		 * @param array $context The context to be made available when loading configs and actions
		 * @return void
		 */
		public function load(Engine $engine, array $environments, array $context)
		{
			$this->engine  = $engine;
			$this->context = $context;

			$this->scanDirectory($this->directory . DIRECTORY_SEPARATOR . 'default');

			foreach ($environments as $environment) {
				$this->scanDirectory($this->directory . DIRECTORY_SEPARATOR . trim($environment));
			}
		}


		/**
		 * Scans an individual directory and adds configs or actions from it to the engine
		 *
		 * @access protected
		 * @param string $directory The directory to scan
		 * @param stirng $base The base directory to exclude from keys
		 * @return void
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
		 * Retrieve the action or config from a given file
		 *
		 * @access protected
		 * @param string $target_file The file to load the action or config from
		 * @return mixed An ActionInterface or ConfigInterface object
		 */
		protected function retrieve($target_file)
		{
			extract($this->context, EXTR_SKIP);

			return Closure::bind(function($target_file) {
				return include $target_file;
			}, $this->engine)($target_file);
		}
	}
}
