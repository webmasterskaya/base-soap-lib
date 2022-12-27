<?php

namespace Webmasterskaya\Soap\Base\Soap\ExtSoap\Configuration;

use Soap\ExtSoapEngine\Configuration\ClassMap\ClassMapCollection;

interface ClientClassMapCollectionInterface
{
    public function __invoke(): ClassMapCollection;
}
