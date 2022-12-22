<?php

namespace Webmasterskaya\Soap\Base\Wsdl\Loader;

interface WsdlLoaderInterface
{
    public function load(string $wsdl): string;
}