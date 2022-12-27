<?php

declare(strict_types=1);

namespace Webmasterskaya\Soap\Base\Soap\ExtSoap\Configuration;

use Soap\ExtSoapEngine\Configuration\ClassMap\ClassMapCollection;

interface ClientClassMapCollectionInterface
{
    public function __invoke(): ClassMapCollection;
}
