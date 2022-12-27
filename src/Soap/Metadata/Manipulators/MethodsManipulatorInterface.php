<?php

declare(strict_types=1);

namespace Webmasterskaya\Soap\Base\Soap\Metadata\Manipulators;

use Soap\Engine\Metadata\Collection\MethodCollection;

interface MethodsManipulatorInterface
{
    public function __invoke(MethodCollection $methods): MethodCollection;
}
