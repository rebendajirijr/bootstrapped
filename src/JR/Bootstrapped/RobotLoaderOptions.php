<?php

namespace JR\Bootstrapped;

use Nette\Object;

/**
 * Description of RobotLoaderOptions.
 *
 * @author RebendaJiri <jiri.rebenda@htmldriven.com>
 */
class RobotLoaderOptions extends Object
{
	/** @var bool */
	private $isEnabled = TRUE;
	
	/** @var string[] */
	private $directories = [];
	
	/**
	 * @return self
	 */
	public function enable()
	{
		$this->isEnabled = TRUE;
		return $this;
	}
	
	/**
	 * @return self
	 */
	public function disable()
	{
		$this->isEnabled = FALSE;
		return $this;
	}
	
	/**
	 * @return bool
	 */
	public function isEnabled()
	{
		return $this->isEnabled;
	}
	
	/**
	 * @param string
	 * @return self
	 */
	public function addDirectory($directory)
	{
		$this->directories[] = $directory;
		return $this;
	}
	
	/**
	 * @param string[]
	 * @return self
	 */
	public function setDirectories(array $directories)
	{
		$this->directories = $directories;
		return $this;
	}
	
	/**
	 * @return string[]
	 */
	public function getDirectories()
	{
		return $this->directories;
	}
}
