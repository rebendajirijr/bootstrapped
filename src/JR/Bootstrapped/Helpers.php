<?php

namespace JR\Bootstrapped;

use Nette\Object;

/**
 * Description of Helpers.
 *
 * @author RebendaJiri <jiri.rebenda@htmldriven.com>
 */
class Helpers extends Object
{
	/**
	 * @throws StaticClassException
	 */
	public function __construct()
	{
		throw new StaticClassException();
	}
	
	/**
	 * Returns TRUE if current environment is development-like, otherwise FALSE.
	 * 
	 * @return bool
	 */
	public static function detectDevelopmentEnvironment()
	{
		global $argv;
		
		if (isset($_SERVER['SERVER_ADDR']) && in_array($_SERVER['SERVER_ADDR'], ['127.0.0.1', '::1'])) {
			return TRUE;
		} elseif (isset($_SERVER['HTTP_HOST']) && (stripos($_SERVER['HTTP_HOST'], 'dev.') === 0 || stripos($_SERVER['HTTP_HOST'], 'localhost') !== FALSE)) { // TODO: better detection
			return TRUE;
		} elseif (isset($argv) && is_array($argv)) { // TODO: some better way of detection while in CLI mode
			if (in_array('dev', $argv)) {
				return TRUE;
			}
		}
		return FALSE;
	}
}
