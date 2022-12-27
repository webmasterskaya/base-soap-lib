<?php

namespace Webmasterskaya\Soap\Base\Soap\ExtSoap\Metadata\Manipulators\DuplicateTypes;

use Webmasterskaya\Soap\Base\Exception\RuntimeException;
use Soap\Engine\Metadata\Collection\PropertyCollection;
use Soap\Engine\Metadata\Collection\TypeCollection;
use Soap\Engine\Metadata\Model\Property;
use Soap\Engine\Metadata\Model\Type;
use Webmasterskaya\Soap\Base\Helper\Normalizer;
use Webmasterskaya\Soap\Base\Soap\Metadata\Manipulators\TypesManipulatorInterface;

class IntersectDuplicateTypesStrategy implements TypesManipulatorInterface
{
    public function __invoke(TypeCollection $types): TypeCollection
    {
        return new TypeCollection(...array_values($types->reduce(
            function (array $result, Type $type) use ($types): array {
                $typeName = $type->getName();

                if (empty($typeName)) {
                    throw new RuntimeException(
                        sprintf('The name of the "%s" cannot be an empty string', get_class($type)));
                }

                $name = Normalizer::normalizeClassname($typeName);
                if (array_key_exists($name, $result)) {
                    return $result;
                }

                return array_merge(
                    $result,
                    [
                        $name => $this->intersectTypes($this->fetchAllTypesNormalizedByName($types, $name))
                    ]
                );
            },
            []
        )));
    }

    private function intersectTypes(TypeCollection $duplicateTypes): Type
    {
        return new Type(
            current(iterator_to_array($duplicateTypes))->getXsdType(),
            $this->uniqueProperties(
                new PropertyCollection(...array_merge(
                    ...$duplicateTypes->map(
                    static function (Type $type): array {
                        return iterator_to_array($type->getProperties());
                    }
                )
                ))
            )
        );
    }

    private function fetchAllTypesNormalizedByName(TypeCollection $types, string $name): TypeCollection
    {
        return $types->filter(static function (Type $type) use ($name): bool {
            $typeName = $type->getName();

            if (empty($typeName)) {
                throw new RuntimeException(
                    sprintf('The name of the "%s" cannot be an empty string', get_class($type)));
            }

            return Normalizer::normalizeClassname($typeName) === $name;
        });
    }

    private function uniqueProperties(PropertyCollection $props): PropertyCollection
    {
        /** @var Property[] $uniqueProperties */
        $uniqueProperties = array_combine(
            $props->map(static function (Property $prop) {
                return $prop->getName();
            }),
            iterator_to_array($props)
        );

        return new PropertyCollection(...array_values($uniqueProperties));
    }
}