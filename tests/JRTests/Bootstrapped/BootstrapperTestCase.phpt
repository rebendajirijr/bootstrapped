<?php

namespace JRTests\Bootstrapped;

use Tester\Assert;
use Tester\Helpers as TesterHelpers;
use Tester\TestCase;
use JR\Bootstrapped\Bootstrapper;
use JR\Bootstrapped\Config;
use JR\Bootstrapped\Options;

require_once __DIR__ . '/../bootstrap.php';

/**
 * Bootstrapper::boot() test cases.
 *
 * @author RebendaJiri <jiri.rebenda@htmldriven.com>
 */
final class BootstrapperTestCase extends TestCase
{
	/*
	 * @inheritdoc
	 */
	protected function setUp()
	{
		parent::setUp();
		
		if (!isset($_SERVER)) {
			$_SERVER = [];
		}
		$_SERVER['SERVER_ADDR'] = '127.0.0.1'; // enforce development environment
	}
	
	/**
	 * @return void
	 */
	public function testBootWithoutConfig()
	{
		$this->clearTempDirectory();
		
		$options = $this->createOptions();
		$options->setPrimaryConfig(NULL);
		$options->setLocalConfig(NULL);
		$options->setConfigs([]);
		
		$bootstrapper = new Bootstrapper($options);
		
		Assert::type('Nette\DI\Container', $bootstrapper->boot());
	}
	
	/**
	 * @return void
	 */
	public function testBootWithConfig()
	{
		$this->clearTempDirectory();
		
		$options = $this->createOptions();
		$options->setPrimaryConfig(new Config(__DIR__ . '/app/resources/config/config.neon'));
		$options->setLocalConfig(new Config(__DIR__ . '/app/resources/config/config.local.neon'));
		
		$bootstrapper = new Bootstrapper($options);
		
		Assert::type('Nette\DI\Container', $bootstrapper->boot());
	}
	
	/**
	 * @return Options
	 */
	private function createOptions()
	{
		$options = new Options();
		$options->setAppDirectory(__DIR__ . '/app');
		$options->setLogDirectory(__DIR__ . '/app/log');
		$options->setTempDirectory(TEMP_DIR);
		return $options;
	}
	
	/**
	 * @return void
	 */
	private function clearTempDirectory()
	{
		TesterHelpers::purge(TEMP_DIR);
	}
}

run(new BootstrapperTestCase());
