<?php

namespace JRTests\Bootstrapped;

use Tester\Assert;
use Tester\TestCase;
use JR\Bootstrapped\Config;
use JR\Bootstrapped\Options;
use JR\Bootstrapped\RobotLoaderOptions;

require_once __DIR__ . '/../bootstrap.php';

/**
 * Description of OptionsTestCase.
 *
 * @author RebendaJiri <jiri.rebenda@htmldriven.com>
 */
final class OptionsTestCase extends TestCase
{
	/**
	 * @return void
	 */
	public function testGetAppDirectory()
	{
		$options = new Options();
		$realpath = realpath($options->getAppDirectory());
		
		Assert::type('string', $realpath); // ensure it's not FALSE
		Assert::same(realpath(__DIR__), $realpath);
		
		$options->setAppDirectory(__DIR__ . '/app');
		$realpath = realpath($options->getAppDirectory());
		
		Assert::type('string', $realpath); // ensure it's not FALSE
		Assert::same(realpath(__DIR__ . '/app'), $realpath);
	}
	
	/**
	 * @return void
	 */
	public function testGetLogDirectory()
	{
		$options = new Options();
		$realpath = realpath($options->getLogDirectory());
		
		Assert::type('string', $realpath); // ensure it's not FALSE
		Assert::same(realpath(__DIR__ . '/log'), $realpath);
		
		$options->setLogDirectory(__DIR__ . '/app/log');
		$realpath = realpath($options->getLogDirectory());
		
		Assert::type('string', $realpath); // ensure it's not FALSE
		Assert::same(realpath(__DIR__ . '/app/log'), $realpath);
	}
	
	/**
	 * @return void
	 */
	public function testGetTempDirectory()
	{
		$options = new Options();
		$realpath = realpath($options->getTempDirectory());
		
		Assert::type('string', $realpath); // ensure it's not FALSE
		Assert::same(realpath(__DIR__ . '/temp'), $realpath);
		
		$options->setTempDirectory(__DIR__ . '/app/temp');
		$realpath = realpath($options->getTempDirectory());
		
		Assert::type('string', $realpath); // ensure it's not FALSE
		Assert::same(realpath(__DIR__ . '/app/temp'), $realpath);
	}
	
	/**
	 * @return void
	 */
	public function testGetPrimaryConfig()
	{
		$options = new Options();
		
		Assert::type('JR\Bootstrapped\Config', $options->getPrimaryConfig());
		
		$config = new Config(__DIR__ . '/app/resources/config/config.neon');
		$options->setPrimaryConfig($config);
		Assert::same($config, $options->getPrimaryConfig());
		
		$options->setPrimaryConfig(NULL);
		Assert::null($options->getPrimaryConfig());
	}
	
	/**
	 * @return void
	 */
	public function testGetLocalConfig()
	{
		$options = new Options();
		
		Assert::type('JR\Bootstrapped\Config', $options->getLocalConfig());
		
		$config = new Config(__DIR__ . '/app/resources/config/config.local.2.neon');
		$options->setLocalConfig($config);
		Assert::same($config, $options->getLocalConfig());
		
		$options->setLocalConfig(NULL);
		Assert::null($options->getLocalConfig());
	}
	
	/**
	 * @return void
	 */
	public function testGetConfigs()
	{
		$options = new Options();
		
		Assert::same([], $options->getConfigs());
		
		$configs = [
			new Config(__DIR__ . '/app/resources/config/config.1.neon'),
			new Config(__DIR__ . '/app/resources/config/config.2.neon'),
		];
		$options->setConfigs($configs);
		Assert::same($configs, $options->getConfigs());
	}
	
	/**
	 * @return void
	 */
	public function testIsDevelopmentEnvironment()
	{
		$options = new Options();
		
		Assert::false($options->isDevelopmentEnvironment());
		
		$options->setDevelopmentEnvironment(TRUE);
		Assert::true($options->isDevelopmentEnvironment());
		
		$options->setDevelopmentEnvironment(FALSE);
		Assert::false($options->isDevelopmentEnvironment());
		
		Assert::exception(function () use ($options) {
			$options->setDevelopmentEnvironment('true');
		}, 'Nette\Utils\AssertionException');
		
		Assert::exception(function () use ($options) {
			$options->setDevelopmentEnvironment('null');
		}, 'Nette\Utils\AssertionException');
	}
	
	/**
	 * @return void
	 */
	public function testGetAllowedIPsForDebugging()
	{
		$options = new Options();
		
		Assert::null($options->getAllowedIPsForDebugging());
		
		$allowedIPsForDebugging = [
			'217.12.1.125',
			'37.193.134.104',
			'210.75.14.146',
		];
		$options->setAllowedIPsForDebugging($allowedIPsForDebugging);
		Assert::same($allowedIPsForDebugging, $options->getAllowedIPsForDebugging());
		
		$options->setAllowedIPsForDebugging(NULL);
		Assert::null($options->getAllowedIPsForDebugging());
	}
	
	/**
	 * @return void
	 */
	public function testErrorNotificationEmail()
	{
		$options = new Options();
		
		Assert::null($options->getErrorNotificationEmail());
		
		$errorNotificationEmail = 'developer@github.com';
		$options->setErrorNotificationEmail($errorNotificationEmail);
		Assert::same($errorNotificationEmail, $options->getErrorNotificationEmail());
		
		$options->setErrorNotificationEmail(NULL);
		Assert::null($options->getErrorNotificationEmail());
	}
	
	/**
	 * return void
	 */
	public function testGetRobotLoaderOptions()
	{
		$options = new Options();
		
		Assert::null($options->getRobotLoaderOptions());
		
		$robotLoaderOptions = new RobotLoaderOptions();
		$robotLoaderOptions->disable();
		$options->setRobotLoaderOptions($robotLoaderOptions);
		Assert::same($robotLoaderOptions, $options->getRobotLoaderOptions());
		
		$options->setRobotLoaderOptions(NULL);
		Assert::null($options->getRobotLoaderOptions());
	}
}

run(new OptionsTestCase());
