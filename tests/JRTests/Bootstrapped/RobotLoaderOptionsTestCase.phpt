<?php

namespace JRTests\Bootstrapped;

use Tester\Assert;
use Tester\TestCase;
use JR\Bootstrapped\RobotLoaderOptions;

require_once __DIR__ . '/../bootstrap.php';

/**
 * Tests basic behaviour of RobotLoaderOptions configuration object.
 *
 * @author RebendaJiri <jiri.rebenda@htmldriven.com>
 */
final class RobotLoaderOptionsTestCase extends TestCase
{
	/**
	 * @return void
	 */
	public function testIsEnabled()
	{
		$robotLoaderOptions = new RobotLoaderOptions();
		Assert::true($robotLoaderOptions->isEnabled());
		
		$robotLoaderOptions->disable();
		Assert::false($robotLoaderOptions->isEnabled());
		
		$robotLoaderOptions->enable();
		Assert::true($robotLoaderOptions->isEnabled());
	}
	
	/**
	 * @return void
	 */
	public function testDirectories()
	{
		$directories = [
			0 => __DIR__ . '/app',
		];
		
		$robotLoaderOptions = new RobotLoaderOptions();
		$robotLoaderOptions->setDirectories($directories);
		
		Assert::same($directories, $robotLoaderOptions->getDirectories());
		
		$directories[1] = __DIR__ . '/libs';
		$robotLoaderOptions->addDirectory($directories[1]);
		
		Assert::same($directories, $robotLoaderOptions->getDirectories());
	}
}

run(new RobotLoaderOptionsTestCase());
