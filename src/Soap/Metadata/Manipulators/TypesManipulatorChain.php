<?php

namespace Webmasterskaya\Soap\Base\Soap\Metadata\Manipulators;

use Soap\Engine\Metadata\Collection\TypeCollection;

final class TypesManipulatorChain implements TypesManipulatorInterface
{
    /**
     * @var TypesManipulatorInterface[]
     */
    private array $manipulators;

    public function __construct(TypesManipulatorInterface ...$manipulators)
    {
        $this->manipulators = $manipulators;
    }

    public function __invoke(TypeCollection $types): TypeCollection
    {
        return array_reduce(
            $this->manipulators,
            static function (TypeCollection $types, TypesManipulatorInterface $manipulator): TypeCollection {
                return $manipulator($types);
            },
            $types
        );
    }
}
