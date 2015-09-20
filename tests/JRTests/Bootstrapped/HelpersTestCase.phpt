<?php

namespace JRTests\Bootstrapped;

use Tester\Assert;
use Tester\TestCase;
use JR\Bootstrapped\Helpers;

require_once __DIR__ . '/../bootstrap.php';

/**
 * Helpers class test cases.
 *
 * @author RebendaJiri <jiri.rebenda@htmldriven.com>
 */
final class HelpersTestCase extends TestCase
{
	/** @var array */
	private $server;
	
	/*
	 * @inheritdoc
	 */
	protected function setUp()
	{
		parent::setUp();
		
		$this->server = isset($_SERVER) ? $_SERVER : [];
	}
	
	/**
	 * @return void
	 */
	public function testDetectDevelopmentEnvironmentByServerAddr()
	{
		$this->resetServer();
		
		$_SERVER['SERVER_ADDR'] = NULL;
		Assert::false(Helpers::detectDevelopmentEnvironment());
		
		$_SERVER['SERVER_ADDR'] = '127.0.0.1';
		Assert::true(Helpers::detectDevelopmentEnvironment());
		
		$_SERVER['SERVER_ADDR'] = '::1';
		Assert::true(Helpers::detectDevelopmentEnvironment());
		
		$_SERVER['SERVER_ADDR'] = '83.84.85.86';
		Assert::false(Helpers::detectDevelopmentEnvironment());
	}
	
	/**
	 * @return void
	 */
	public function testDetectDevelopmentEnvironmentByHost()
	{
		$this->resetServer();
		
		$_SERVER['HTTP_HOST'] = NULL;
		Assert::false(Helpers::detectDevelopmentEnvironment());
		
		$_SERVER['HTTP_HOST'] = 'localhost';
		Assert::true(Helpers::detectDevelopmentEnvironment());
		
		$_SERVER['HTTP_HOST'] = 'myProject.localhost';
		Assert::true(Helpers::detectDevelopmentEnvironment());
		
		$_SERVER['HTTP_HOST'] = 'myProject.local';
		Assert::false(Helpers::detectDevelopmentEnvironment());
		
		$_SERVER['HTTP_HOST'] = 'dev.myProject.com';
		Assert::true(Helpers::detectDevelopmentEnvironment());
		
		$_SERVER['HTTP_HOST'] = 'devel.myProject.com';
		Assert::false(Helpers::detectDevelopmentEnvironment());
	}
	
	/**
	 * @return void
	 */
	private function resetServer()
	{
		$_SERVER = $this->server;
	}
}

run(new HelpersTestCase());
