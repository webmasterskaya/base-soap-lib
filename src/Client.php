<?php

namespace Webmasterskaya\Soap\Base;

use Webmasterskaya\Soap\Base\Exception\InvalidArgumentException;
use Webmasterskaya\Soap\Base\Helper\ClassHelper;
use Webmasterskaya\Soap\Base\TypeConverter\TypeConverterInterface;

abstract class Client extends \Laminas\Soap\Client implements ClientInterface
{
    /**
     * @var array
     */
    protected $aliases;

    public function setClassmap(array $classmap)
    {
        parent::setClassmap($classmap);

        $aliases = [];

        foreach ($this->getClassmap() as $wsdlType => $phpClassName) {
            $aliases[strtolower($wsdlType)] = $wsdlType;
        }

        $this->aliases = $aliases;

        return $this;
    }

    public function setTypemap(array $typeMap)
    {
        $newTypeMap = [];

        foreach ($typeMap as $type) {
            // Classic array configuration
            if (!$type instanceof TypeConverterInterface) {
                if (!is_callable($type['from_xml'])) {
                    throw new Exception\InvalidArgumentException(sprintf(
                        'Invalid from_xml callback for type: %s',
                        $type['type_name']
                    ));
                }

                if (!is_callable($type['to_xml'])) {
                    throw new Exception\InvalidArgumentException(sprintf(
                        'Invalid to_xml callback for type: %s',
                        $type['type_name']
                    ));
                }

                $newTypeMap[] = $type;
                continue;
            }

            $newTypeMap[] = [
                'type_name' => $type->getTypeName(),
                'type_ns' => $type->getTypeNamespace(),
                'from_xml' => function ($input) use ($type) {
                    return $type->convertXmlToPhp($input);
                },
                'to_xml' => function ($input) use ($type) {
                    return $type->convertPhpToXml($input);
                },
            ];
        }

        $this->typemap = $newTypeMap;
        $this->soapClient = null;
        return $this;
    }

    public function getFromClassMap($key)
    {
        $classMap = $this->getClassMap();
        $wsdlTypeName = $this->resolveAlias($key);

        if (!isset($classMap[$wsdlTypeName])) {
            throw new InvalidArgumentException('Invalid SOAP method: ' . $key);
        }

        return $classMap[$wsdlTypeName];
    }

    public function __call($name, $arguments)
    {
        $phpClass = $this->getFromClassMap($name);

        if (!ClassHelper::shouldImplement($phpClass, Type\RequestInterface::class)) {
            throw new InvalidArgumentException('SOAP method must should implement of RequestInterface');
        }

        return parent::__call($name, $arguments);
    }

    protected function _preProcessArguments($arguments)
    {
        $lastMethod = $this->getLastMethod();
        $phpClass = $this->getFromClassMap($lastMethod);

        return [new $phpClass(...$arguments)];
    }

    protected function _preProcessResult($result)
    {
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