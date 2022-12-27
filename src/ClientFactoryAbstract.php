<?php

namespace Webmasterskaya\Soap\Base;

use Soap\Engine\Transport;
use Soap\ExtSoapEngine\Configuration\ClassMap\ClassMap;
use Soap\ExtSoapEngine\Configuration\ClassMap\ClassMapCollection;
use Soap\ExtSoapEngine\Configuration\ClassMap\ClassMapInterface;
use Soap\ExtSoapEngine\Configuration\TypeConverter\TypeConverterCollection;
use Soap\ExtSoapEngine\Configuration\TypeConverter\TypeConverterInterface;
use Soap\ExtSoapEngine\ExtSoapOptions;
use Soap\ExtSoapEngine\Wsdl\PassThroughWsdlProvider;
use Soap\ExtSoapEngine\Wsdl\WsdlProvider;
use Webmasterskaya\Soap\Base\Exception\InvalidArgumentException;
use Webmasterskaya\Soap\Base\Helper\ClassHelper;
use Webmasterskaya\Soap\Base\Soap\ExtSoap\Configuration\ClientClassMapCollectionInterface;
use Webmasterskaya\Soap\Base\Soap\ExtSoap\Configuration\ClientTypeConverterCollectionInterface;
use Webmasterskaya\Soap\Base\Soap\Metadata\MetadataOptions;

abstract class ClientFactoryAbstract implements ClientFactoryInterface
{
    /**
     * @var string
     */
    protected static $clientClass = null;

    public static function create(
        array $options,
        string $wsdlProviderClass = PassThroughWsdlProvider::class,
        ?ClientClassMapCollectionInterface $classMap = null,
        ?ClientTypeConverterCollectionInterface $typeMap = null,
        ?Transport $transport = null,
        ?MetadataOptions $metadataOptions = null
    ): ClientInterface {
        if (!ClassHelper::shouldImplement($wsdlProviderClass, WsdlProvider::class)) {
            throw new InvalidArgumentException(
                sprintf('Wsdl provider class must be implement of "%s", "%s" given',
                    PassThroughWsdlProvider::class,
                    implode('", "', class_implements($wsdlProviderClass))));
        }

        $clientOptions = new ExtSoapOptions('', $options);

        $clientOptions->withWsdlProvider(new $wsdlProviderClass);

        if ($classMap !== null) {
            $clientClassMap = static::mergeClassMapCollections(
                call_user_func([static::class, 'getDefaultClientClassMap'])(),
                $classMap()
            );
        } else {
            $clientClassMap = call_user_func([static::class, 'getDefaultClientClassMap'])();
        }

        $clientOptions->withClassMap($clientClassMap);

        if ($typeMap !== null) {
            $clientOptions->withTypeMap($typeMap());
        }

        $clientClass = static::getClientClassName();

        return new static::$clientClass($clientOptions, $transport, $metadataOptions);
    }

    public static function mergeClassMapCollections(
        ClassMapCollection ...$classMapCollections
    ): ClassMapCollection {
        $numArgs = func_num_args();
        if ($numArgs < 1) {
            throw new InvalidArgumentException(
                sprintf('"%s::mergeClassMapCollections()" expects at least 1 parameters, %s given',
                    static::class,
                    $numArgs
                ));
        }

        /** @var array<ClassMapInterface> $merged */
        $merged = [];

        foreach ($classMapCollections as $classMapCollection) {
            /** @var array<string, ClassMapInterface> $classMaps */
            $classMaps = array_map(
                static function (ClassMap $classMap) {
                    return [
                        strtolower($classMap->getWsdlType()),
                        $classMap
                    ];
                },
                iterator_to_array($classMapCollection)
            );
            $merged = array_merge($merged, $classMaps);
        }

        return new ClassMapCollection(...array_values($merged));
    }

    public static function mergeTypeMapCollections(
        TypeConverterCollection ...$typeConverterCollections
    ): TypeConverterCollection {
        $numArgs = func_num_args();
        if ($numArgs < 1) {
            throw new InvalidArgumentException(
                sprintf('"%s::mergeTypeMapCollections()" expects at least 1 parameters, %s given',
                    static::class,
                    $numArgs
                ));
        }

        /** @var array<TypeConverterInterface> $merged */
        $merged = [];

        foreach ($typeConverterCollections as $typeConverterCollection) {
            /** @var array<string, TypeConverterInterface> $typeMaps */
            $typeMaps = array_map(
                static function (TypeConverterInterface $converter) {
                    return [
                        strtolower($converter->getTypeName()),
                        $converter
                    ];
                },
                iterator_to_array($typeConverterCollection)
            );
            $merged = array_merge($merged, $typeMaps);
        }

        return new TypeConverterCollection(array_values($merged));
    }

    public static function getClientClassName(): string
    {
        $classname = static::$clientClass;

        if (empty($classname)) {
            $classname = substr(static::class, 0, -7);
        }

        if (!class_exists($classname)) {
            throw new \RuntimeException(sprintf('Unable to load client class "%s"', $classname));
        }

        if (!ClassHelper::shouldImplement($classname, ClientInterface::class)) {
            throw new InvalidArgumentException(
                sprintf('Client class name must be implement of "%s", "%s" given',
                    PassThroughWsdlProvider::class,
                    implode('", "', class_implements($classname))));
        }

        return $classname;
    }

    public static function getEmptyClassMap(): ClientClassMapCollectionInterface
    {
        return new class implements ClientClassMapCollectionInterface {
            public function __invoke(): ClassMapCollection
            {
                return new ClassMapCollection();
            }
        };
    }

    public static function getEmptyTypeMap(): ClientTypeConverterCollectionInterface
    {
        return new class implements ClientTypeConverterCollectionInterface {
            public function __invoke(): TypeConverterCollection
            {
                return new TypeConverterCollection();
            }
        };
    }
}