<?php

namespace Webmasterskaya\Soap\Base\Soap\Metadata;

use Soap\Engine\Metadata\Collection\MethodCollection;
use Soap\Engine\Metadata\Collection\TypeCollection;
use Soap\Engine\Metadata\Metadata;
use Webmasterskaya\Soap\Base\Soap\Metadata\Manipulators\MethodsManipulatorInterface;
use Webmasterskaya\Soap\Base\Soap\Metadata\Manipulators\TypesManipulatorInterface;

class ManipulatedMetadata implements Metadata
{
    private Metadata $metadata;
    private TypesManipulatorInterface $typesChangingStrategy;
    private MethodsManipulatorInterface $methodsChangingStrategyInterface;

    public function __construct(
        Metadata $metadata,
        MethodsManipulatorInterface $methodsChangingStrategyInterface,
        TypesManipulatorInterface $typesChangingStrategy
    ) {
        $this->metadata = $metadata;
        $this->methodsChangingStrategyInterface = $methodsChangingStrategyInterface;
        $this->typesChangingStrategy = $typesChangingStrategy;
    }

    public function getTypes(): TypeCollection
    {
        return ($this->typesChangingStrategy)($this->metadata->getTypes());
    }

    public function getMethods(): MethodCollection
    {
        return ($this->methodsChangingStrategyInterface)($this->metadata->getMethods());
    }
}
