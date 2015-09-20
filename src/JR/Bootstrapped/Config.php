<?php

namespace JR\Bootstrapped;

use Nette\Object;
use Nette\Utils\AssertionException;
use Nette\Utils\Validators;

/**
 * Description of Config.
 *
 * @author RebendaJiri <jiri.rebenda@htmldriven.com>
 * 
 * @property string $file
 */
class Config extends Object
{
	/** @var string */
	private $file;
	
	/**
	 * @param string
	 * @throws AssertionException
	 */
	public function __construct($file)
	{
		$this->setFile($file);
	}
	
	/**
	 * @param string
	 * @return self
	 * @throws AssertionException
	 */
	public function setFile($file)
	{
		Validators::assert($file, 'string');
		$this->file = $file;
		return $this;
	}
	
	/**
	 * @return string
	 */
	public function getFile()
	{
		return $this->file;
	}
}
