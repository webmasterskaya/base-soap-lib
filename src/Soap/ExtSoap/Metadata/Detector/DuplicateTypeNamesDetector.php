<?php

namespace Webmasterskaya\Soap\Base\Soap\ExtSoap\Metadata\Detector;

use Webmasterskaya\Soap\Base\Exception\RuntimeException;
use Soap\Engine\Metadata\Collection\TypeCollection;
use Soap\Engine\Metadata\Model\Type;
use Webmasterskaya\Soap\Base\Helper\Normalizer;

final class DuplicateTypeNamesDetector
{
    /**
     * @param TypeCollection $types
     *
     * @return string[]
     */
    public function __invoke(TypeCollection $types): array
    {
        return array_keys(
            array_filter(
                array_count_values($types->map(
                    static function (Type $type): string {
                        $typeName = $type->getName();
                        if (!empty($typeName)) {
                            return Normalizer::normalizeClassname($typeName);
                        }

                        throw new RuntimeException(
                            sprintf('The name of the "%s" cannot be an empty string', get_class($type)));
                    }
                )),
                static function (int $count): bool {
                    return $count > 1;
                }
            )
        );
    }
}