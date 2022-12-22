<?php

namespace Webmasterskaya\Soap\Base\Wsdl\Provider;

interface WsdlProviderInterface
{
    public function provide(string $source): string;
}