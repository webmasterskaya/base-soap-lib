<?php

namespace Webmasterskaya\Soap\Base\ClassMap;

interface ClassMapInterface
{
    /**
     * @return string
     */
    public function getWsdlType(): string;

    /**
     * @return string
     */
    public function getPhpClassName(): string;
}