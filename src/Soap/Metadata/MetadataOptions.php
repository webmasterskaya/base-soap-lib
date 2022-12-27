<?php


namespace Webmasterskaya\Soap\Base\Soap\Metadata;

use Webmasterskaya\Soap\Base\Soap\Metadata\Manipulators\MethodsManipulatorChain;
use Webmasterskaya\Soap\Base\Soap\Metadata\Manipulators\MethodsManipulatorInterface;
use Webmasterskaya\Soap\Base\Soap\Metadata\Manipulators\TypesManipulatorChain;
use Webmasterskaya\Soap\Base\Soap\Metadata\Manipulators\TypesManipulatorInterface;

final class MetadataOptions
{
    /**
     * @var MethodsManipulatorInterface
     */
    private $methodsManipulator;

    /**
     * @var TypesManipulatorInterface
     */
    private $typesManipulator;

    public function __construct(
        MethodsManipulatorInterface $methodsManipulator,
        TypesManipulatorInterface $typesManipulator
    ) {
        $this->methodsManipulator = $methodsManipulator;
        $this->typesManipulator = $typesManipulator;
    }

    public static function empty(): self
    {
        return new self(new MethodsManipulatorChain(), new TypesManipulatorChain());
    }

    public function withMethodsManipulator(MethodsManipulatorInterface $methodsManipulator): self
    {
        $new = clone $this;
        $new->methodsManipulator = $methodsManipulator;

        return $new;
    }

    public function withTypesManipulator(TypesManipulatorInterface $typesManipulator): self
    {
        $new = clone $this;
        $new->typesManipulator = $typesManipulator;

        return $new;
    }

    public function getMethodsManipulator(): MethodsManipulatorInterface
    {
        return $this->methodsManipulator;
    }

    public function getTypesManipulator(): TypesManipulatorInterface
    {
        return $this->typesManipulator;
    }
}
