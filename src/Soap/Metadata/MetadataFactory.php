<?php

declare(strict_types=1);

namespace Webmasterskaya\Soap\Base\Soap\Metadata;

use Soap\Engine\Metadata\LazyInMemoryMetadata;
use Soap\Engine\Metadata\Metadata;

final class MetadataFactory
{
    public static function lazy(Metadata $metadata): Metadata
    {
        return new LazyInMemoryMetadata($metadata);
    }

    public static function manipulated(Metadata $metadata, MetadataOptions $options): Metadata
    {
        return self::lazy(
            new ManipulatedMetadata(
                $metadata,
                $options->getMethodsManipulator(),
                $options->getTypesManipulator()
            )
        );
    }
}
