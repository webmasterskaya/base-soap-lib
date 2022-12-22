<?php
declare(strict_types=1);

namespace Webmasterskaya\Soap\Base\ClassMap;

interface ClassMapInterface
{
    public function getWsdlType(): string;

    public function getPhpClassName(): string;
}
