<?php

declare(strict_types=1);

namespace Webmasterskaya\Soap\Base\Soap\ExtSoap\Metadata\Manipulators\DuplicateTypes;

use Soap\Engine\Metadata\Collection\TypeCollection;
use Soap\Engine\Metadata\Model\Type;
use Webmasterskaya\Soap\Base\Exception\RuntimeException;
use Webmasterskaya\Soap\Base\Helper\Normalizer;
use Webmasterskaya\Soap\Base\Soap\ExtSoap\Metadata\Detector\DuplicateTypeNamesDetector;
use Webmasterskaya\Soap\Base\Soap\Metadata\Manipulators\TypesManipulatorInterface;

final class RemoveDuplicateTypesStrategy implements TypesManipulatorInterface
{
    public function __invoke(TypeCollection $types): TypeCollection
    {
        $duplicateNames = (new DuplicateTypeNamesDetector())($types);

        return $types->filter(static function (Type $type) use ($duplicateNames): bool {
            $typeName = $type->getName();
            if (empty($typeName)) {
                throw new RuntimeException(
                    sprintf('The name of the "%s" cannot be an empty string', get_class($type))
                );
            }

            return !in_array(
                Normalizer::normalizeClassname($typeName),
                $duplicateNames,
                true
            );
        });
    }
}
