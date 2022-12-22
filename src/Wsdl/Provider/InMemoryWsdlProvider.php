<?php

declare(strict_types=1);

namespace Webmasterskaya\Soap\Base\Wsdl\Provider;

class InMemoryWsdlProvider implements WsdlProviderInterface
{
    public function provide(string $source): string
    {
        return 'data://text/plain;base64,' . base64_encode($source);
    }
}
