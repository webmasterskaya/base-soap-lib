<?php

namespace Webmasterskaya\Soap\Base\Soap\Metadata\Manipulators;

use Soap\Engine\Metadata\Collection\MethodCollection;

final class MethodsManipulatorChain implements MethodsManipulatorInterface
{
    /**
     * @var MethodsManipulatorInterface[]
     */
    private array $manipulators;

    public function __construct(MethodsManipulatorInterface ...$manipulators)
    {
        $this->manipulators = $manipulators;
    }

    public function __invoke(MethodCollection $methods): MethodCollection
    {
        return array_reduce(
            $this->manipulators,
            static function (MethodCollection $methods, MethodsManipulatorInterface $manipulator): MethodCollection {
                return $manipulator($methods);
            },
            $methods
        );
    }
}
