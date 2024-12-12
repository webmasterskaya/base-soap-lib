<?php

namespace Webmasterskaya\Soap\Base\Helper;

use Soap\ExtSoapEngine\Configuration\TypeConverter\TypeConverterCollection;
use Soap\ExtSoapEngine\Configuration\TypeConverter\TypeConverterInterface;
use Webmasterskaya\Soap\Base\Exception\InvalidArgumentException;
use Webmasterskaya\Soap\Base\Soap\ExtSoap\Configuration\ClientTypeConverterCollectionInterface;

class TypeMapHelper
{
    public static function mergeTypeMapCollections(
        TypeConverterCollection ...$typeConverterCollections
    ): TypeConverterCollection {
        $numArgs = func_num_args();
        if ($numArgs < 1) {
            throw new InvalidArgumentException(
                sprintf(
                    '"%s::mergeTypeMapCollections()" expects at least 1 parameters, %s given',
                    static::class,
                    $numArgs
                )
            );
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
            $merged   = array_merge($merged, $typeMaps);
        }

        return new TypeConverterCollection(array_values($merged));
    }

    public static function getEmptyTypeMap(): ClientTypeConverterCollectionInterface
    {
        return new class () implements ClientTypeConverterCollectionInterface {
            public function __invoke(): TypeConverterCollection
            {
                return new TypeConverterCollection();
            }
        };
    }
}
