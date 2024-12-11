<?php

namespace Webmasterskaya\Soap\Base\Helper;

use Soap\ExtSoapEngine\Configuration\ClassMap\ClassMap;
use Soap\ExtSoapEngine\Configuration\ClassMap\ClassMapCollection;
use Soap\ExtSoapEngine\Configuration\ClassMap\ClassMapInterface;
use Webmasterskaya\Soap\Base\Exception\InvalidArgumentException;
use Webmasterskaya\Soap\Base\Soap\ExtSoap\Configuration\ClientClassMapCollectionInterface;

class ClassMapHelper
{
    public static function mergeClassMapCollections(
        ClassMapCollection ...$classMapCollections
    ): ClassMapCollection {
        $numArgs = func_num_args();
        if ($numArgs < 1) {
            throw new InvalidArgumentException(
                sprintf(
                    '"%s::mergeClassMapCollections()" expects at least 1 parameters, %s given',
                    static::class,
                    $numArgs
                )
            );
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
            $merged    = array_merge($merged, $classMaps);
        }

        return new ClassMapCollection(...array_values($merged));
    }

    public static function getEmptyClassMap(): ClientClassMapCollectionInterface
    {
        return new class () implements ClientClassMapCollectionInterface {
            public function __invoke(): ClassMapCollection
            {
                return new ClassMapCollection();
            }
        };
    }
}