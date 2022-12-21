<?php

namespace Webmasterskaya\Soap\Base;

use Webmasterskaya\Soap\Base\Helper\ClassHelper;

abstract class Client extends \Laminas\Soap\Client implements ClientInterface
{
	/**
	 * @var array
	 */
	protected $aliases;

	/**
	 * Last invoked request class
	 *
	 * @var string
	 */
	protected $lastClass = '';

	public function setClassmap(array $classmap)
	{
		$classmap = array_merge($this->getDefaultClassMap(), $classmap);

		foreach ($classmap as $wsdlType => $phpClassName)
		{
			if (!class_exists($phpClassName))
			{
				throw new \Laminas\Soap\Exception\InvalidArgumentException('Invalid class in class map: ' . $phpClassName);
			}

			$this->classmap[$wsdlType] = $phpClassName;
			$this->alias(strtolower($wsdlType), $wsdlType);
		}

		$this->soapClient = null;

		return $this;
	}

	/**
	 * Retrieve last invoked request class
	 *
	 * @return string
	 */
	public function getLastClass()
	{
		return $this->lastClass;
	}

	public function __call($name, $arguments)
	{
		$phpClassName = $this->resolveAlias($name);

		$classMap = $this->getClassMap();

		if (!isset($classMap[$phpClassName]))
		{
			throw new \Laminas\Soap\Exception\InvalidArgumentException('Invalid SOAP method: ' . $name);
		}

		if (!ClassHelper::shouldImplement($phpClassName, '\\Webmasterskaya\\Soap\\Base\\Type\\RequestInterface'))
		{
			throw new \Laminas\Soap\Exception\InvalidArgumentException('SOAP method must should implement of RequestInterface');
		}

		$this->lastClass = $phpClassName;

		parent::__call($name, $arguments);
	}

	protected function _preProcessArguments($arguments)
	{
		return new $this->lastClass(...$arguments);
	}

	protected function _preProcessResult($result)
	{
		var_dump($result);

		return $result;
	}

	public function alias($alias, $key)
	{
		$this->aliases[$alias] = $key;

		return $this;
	}

	protected function resolveAlias($resourceName)
	{
		return $this->aliases[$resourceName] ?? $this->aliases[strtolower($resourceName)] ?? $resourceName;
	}
}