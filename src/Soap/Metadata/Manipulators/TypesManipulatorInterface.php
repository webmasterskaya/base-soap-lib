<?php

namespace Webmasterskaya\Soap\Base\Soap\Metadata\Manipulators;

use Soap\Engine\Metadata\Collection\TypeCollection;

interface TypesManipulatorInterface
{
    public function __invoke(TypeCollection $types): TypeCollection;
}