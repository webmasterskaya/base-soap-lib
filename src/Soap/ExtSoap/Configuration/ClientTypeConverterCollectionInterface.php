<?php

declare(strict_types=1);

namespace Webmasterskaya\Soap\Base\Soap\ExtSoap\Configuration;

use Soap\ExtSoapEngine\Configuration\TypeConverter\TypeConverterCollection;

interface ClientTypeConverterCollectionInterface
{
    public function __invoke(): TypeConverterCollection;
}
