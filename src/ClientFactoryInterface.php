<?php

namespace Webmasterskaya\Soap\Base;

use Psr\EventDispatcher\EventDispatcherInterface;
use Soap\Engine\Transport;
use Soap\ExtSoapEngine\ExtSoapOptions;
use Webmasterskaya\Soap\Base\Soap\Metadata\MetadataOptions;

interface ClientFactoryInterface
{
    public static function create(
        string $wsdl,
        ?ExtSoapOptions $options = null,
        ?Transport $transport = null,
        ?MetadataOptions $metadataOptions = null,
        ?EventDispatcherInterface $eventDispatcher = null
    ): ClientInterface;
}
