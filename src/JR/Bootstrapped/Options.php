<?php

namespace JR\Bootstrapped;

use Nette\Object;
use Nette\Utils\AssertionException;
use Nette\Utils\Validators;

/**
 * Options to be used in Bootstrapper itself.
 *
 * @author RebendaJiri <jiri.rebenda@htmldriven.com>
 */
class Options extends Object
{
	/** @var NULL */
	const DETECT_DEVELOPMENT_ENVIRONMENT = NULL;
	
	/** @var string */
	private $appDirectory;
	
	/** @var string */
	private $logDirectory;
	
	/** @var string */
	private $tempDirectory;
	
	/** @var Config|NULL */
	private $primaryConfig;
	
	/** @var Config|NULL */
	private $localConfig;
	
	/** @var Config[] */
	private $configs = [];
	
	/** @var bool|NULL */
	private $isDevelopmentEnvironment = self::DETECT_DEVELOPMENT_ENVIRONMENT;
	
	/** @var array|NULL */
	private $allowedIPsForDebugging;
	
	/** @var string|NULL */
	private $errorNotificationEmail;
	
	/** @var RobotLoaderOptions|NULL */
	private $robotLoaderOptions;
	
	public function __construct()
	{
		$this->initializeDefaults();
	}
	
	/**
	 * @param string
	 * @return self
	 */
	public function setAppDirectory($appDirectory)
	{
		$this->appDirectory = $appDirectory;
		return $this;
	}
	
	/**
	 * @return string
	 */
	public function getAppDirectory()
	{
		return $this->appDirectory;
	}
	
	/**
	 * @param string
	 * @return self
	 */
	public function setLogDirectory($logDirectory)
	{
		$this->logDirectory = $logDirectory;
		return $this;
	}
	
	/**
	 * @return string
	 */
	public function getLogDirectory()
	{
		return $this->logDirectory;
	}
	
	/**
	 * @param string
	 * @return self
	 */
	public function setTempDirectory($tempDirectory)
	{
		$this->tempDirectory = $tempDirectory;
		return $this;
	}
	
	/**
	 * @return string
	 */
	public function getTempDirectory()
	{
		return $this->tempDirectory;
	}
	
	/**
	 * @param Config|NULL
	 * @return self
	 */
	public function setPrimaryConfig(Config $config = NULL)
	{
		$this->primaryConfig = $config;
		return $this;
	}
	
	/**
	 * @return Config|NULL
	 */
	public function getPrimaryConfig()
	{
		return $this->primaryConfig;
	}
	
	/**
	 * @param Config|NULL
	 * @return self
	 */
	public function setLocalConfig(Config $config = NULL)
	{
		$this->localConfig = $config;
		return $this;
	}
	
	/**
	 * @return Config|NULL
	 */
	public function getLocalConfig()
	{
		return $this->localConfig;
	}
	
	/**
	 * @param Config
	 * @return self
	 */
	public function addConfig(Config $config)
	{
		$this->configs[] = $config;
		return $this;
	}
	
	/**
	 * @param Config[]
	 * @return self
	 */
	public function setConfigs(array $configs)
	{
		$this->configs = $configs;
		return $this;
	}
	
	/**
	 * @return Config[]
	 */
	public function getConfigs()
	{
		return $this->configs;
	}
	
	/**
	 * @param bool|NULL
	 * @return self
	 * @throws AssertionException
	 */
	public function setIsDevelopmentEnvironment($isDevelopmentEnvironment = self::DETECT_DEVELOPMENT_ENVIRONMENT)
	{
		Validators::assert($isDevelopmentEnvironment, 'bool|null');
		$this->isDevelopmentEnvironment = ($isDevelopmentEnvironment === self::DETECT_DEVELOPMENT_ENVIRONMENT ? Helpers::detectDevelopmentEnvironment() : $isDevelopmentEnvironment);
		return $this;
	}
	
	/**
	 * @return bool
	 */
	public function isDevelopmentEnvironment()
	{
		return $this->isDevelopmentEnvironment;
	}
	
	/**
	 * @param array|NULL
	 * @return self
	 */
	public function setAllowedIPsForDebugging(array $allowedIPsForDebugging = NULL)
	{
		$this->allowedIPsForDebugging = $allowedIPsForDebugging;
		return $this;
	}
	
	/**
	 * @return array|NULL
	 */
	public function getAllowedIPsForDebugging()
	{
		return $this->allowedIPsForDebugging;
	}
	
	/**
	 * @param string|NULL
	 * @return self
	 * @throws AssertionException
	 */
	public function setErrorNotificationEmail($errorNotificationEmail = NULL)
	{
		Validators::assert($errorNotificationEmail, 'string|null');
		$this->errorNotificationEmail = $errorNotificationEmail;
		return $this;
	}
	
	/**
	 * @return string|NULL
	 */
	public function getErrorNotificationEmail()
	{
		return $this->errorNotificationEmail;
	}
	
	/**
	 * @param RobotLoaderOptions|NULL
	 * @return self
	 */
	public function setRobotLoaderOptions(RobotLoaderOptions $robotLoaderOptions = NULL)
	{
		$this->robotLoaderOptions = $robotLoaderOptions;
		return $this;
	}
	
	/**
	 * @return RobotLoaderOptions|NULL
	 */
	public function getRobotLoaderOptions()
	{
		return $this->robotLoaderOptions;
	}
	
	/**
	 * @return void
	 */
	protected function initializeDefaults()
	{
		$this->appDirectory = $this->detectAppDirectory();
		$this->logDirectory = $this->appDirectory . '/log';
		$this->tempDirectory = $this->appDirectory . '/temp';
		
		$this->primaryConfig = new Config($this->appDirectory . '/resources/config/config.neon');
		$this->localConfig = new Config($this->appDirectory . '/resources/config/config.local.neon');
		
		$this->isDevelopmentEnvironment = Helpers::detectDevelopmentEnvironment();
	}
	
	/**
	 * @return string
	 */
	protected function detectAppDirectory()
	{
		$trace = debug_backtrace(PHP_VERSION_ID >= 50306 ? DEBUG_BACKTRACE_IGNORE_ARGS : FALSE);
		$scriptTrace = array_pop($trace);
		if ($scriptTrace !== NULL && isset($scriptTrace['file'])) {
			return dirname($scriptTrace['file']);
		}
		return NULL;
	}
}
