<?php

namespace Webmasterskaya\Soap\Base;

use Webmasterskaya\Soap\Base\Helper\ClassHelper;

class Client extends \Laminas\Soap\Client
{
	/**
	 * @var array
	 */
	protected $classmapAliases;

	/**
	 * Last invoked request class
	 *
	 * @var string
	 */
	protected $lastCalling = '';

	public function setClassmap(array $classmap)
	{
		$aliases = [];

		foreach ($classmap as $type => $class)
		{
			if (!class_exists($class))
			{
				throw new \Laminas\Soap\Exception\InvalidArgumentException('Invalid class in class map: ' . $class);
			}

			$aliases[strtolower($type)] = $class;
		}

		$this->classmap        = $classmap;
		$this->classmapAliases = $aliases;
		$this->soapClient      = null;

		return $this;
	}

	public function getClassMapAliases()
	{
		return $this->classmapAliases;
	}

	/**
	 * Retrieve last invoked request class
	 *
	 * @return string
	 */
	public function getLastCalling()
	{
		return $this->lastCalling;
	}

	public function __call($name, $arguments)
	{
		$aliases = $this->getClassMapAliases();

		if (!isset($aliases[strtolower($name)]))
		{
			throw new \Laminas\Soap\Exception\InvalidArgumentException('Invalid SOAP method: ' . $name);
		}

		$class = $aliases[strtolower($name)];

		if (!ClassHelper::shouldImplement($class, '\\Webmasterskaya\\Soap\\Base\\Type\\RequestInterface'))
		{
			throw new \Laminas\Soap\Exception\InvalidArgumentException('SOAP method must should implement of RequestInterface');
		}

		$this->lastCalling = $class;

		parent::__call($name, $arguments);
	}

	protected function _preProcessArguments($arguments)
	{
		return new $this->lastCalling($arguments);
	}

	protected function _preProcessResult($result)
	{
		var_dump($result);

		return $result;
	}
}