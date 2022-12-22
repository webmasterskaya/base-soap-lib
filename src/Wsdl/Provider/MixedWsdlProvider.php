<?php

namespace Webmasterskaya\Soap\Base\Wsdl\Provider;

class MixedWsdlProvider implements WsdlProviderInterface
{
    public function provide(string $source): string
    {
        return $source;
    }
}