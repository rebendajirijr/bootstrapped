<?php

namespace JR\Bootstrapped;

use Nette\Configurator;
use Nette\Object;

/**
 * Defines common Nette Application entry point.
 * 
 * @author RebendaJiri <jiri.rebenda@htmldriven.com>
 * 
 * @property-read Options $options
 */
class Bootstrapper extends Object
{
	/** @var Options */
	private $options;
	
	/**
	 * @param Options|NULL
	 */
	public function __construct(Options $options = NULL)
	{
		$this->options = ($options === NULL ? $this->createDefaultOptions() : $options);
	}
	
	/**
	 * @return Options
	 */
	public function getOptions()
	{
		return $this->options;
	}
	
	/**
	 * Setups and boots the application.
	 * 
	 * @return Container
	 */
	public function boot()
	{		
		$configurator = new Configurator();
		
		$this->setupDebugger($configurator);
		$this->setupTemp($configurator);
		$this->setupRobotLoader($configurator);
		$this->setupConfiguration($configurator);
		
		return $configurator->createContainer();
	}
	
	/**
	 * @param Configurator
	 * @return void
	 */
	protected function setupDebugger(Configurator $configurator)
	{
		if (($allowedIPsForDebugging = $this->options->getAllowedIPsForDebugging()) !== NULL) {
			$configurator->setDebugMode($allowedIPsForDebugging);
		}
		$configurator->enableDebugger($this->options->getLogDirectory(), $this->options->getErrorNotificationEmail());
	}
	
	/**
	 * @param Configurator
	 * @return void
	 */
	protected function setupTemp(Configurator $configurator)
	{
		$configurator->setTempDirectory($this->options->getTempDirectory());
	}
	
	/**
	 * @param Configurator
	 * @return void
	 */
	protected function setupRobotLoader(Configurator $configurator)
	{
		if ($this->options->getRobotLoaderOptions() !== NULL && $this->options->getRobotLoaderOptions()->isEnabled()) {
			$robotLoader = $configurator->createRobotLoader();
			foreach ($this->options->getRobotLoaderOptions()->getDirectories() as $directory) {
				$robotLoader->addDirectory($directory);
			}
			$robotLoader->register();
		}
	}
	
	/**
	 * @param Configurator
	 * @return void
	 */
	protected function setupConfiguration(Configurator $configurator)
	{
		if ($this->options->getPrimaryConfig() !== NULL) {
			$configurator->addConfig($this->options->getPrimaryConfig()->getFile());
		}
		if ($this->options->getLocalConfig() !== NULL && Helpers::detectDevelopmentEnvironment()) {
			$configurator->addConfig($this->options->getLocalConfig()->getFile());
		}
		foreach ($this->options->getConfigs() as $config) {
			$configurator->addConfig($config->getFile());
		}
	}
	
	/**
	 * @return Options
	 */
	protected function createDefaultOptions()
	{
		return new Options();
	}
}
