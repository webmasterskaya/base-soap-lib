<?php

namespace Webmasterskaya\Soap\Base;

use Soap\Engine\Transport;
use Soap\ExtSoapEngine\Wsdl\PassThroughWsdlProvider;
use Webmasterskaya\Soap\Base\Soap\ExtSoap\Configuration\ClientClassMapCollectionInterface;
use Webmasterskaya\Soap\Base\Soap\ExtSoap\Configuration\ClientTypeConverterCollectionInterface;
use Webmasterskaya\Soap\Base\Soap\Metadata\MetadataOptions;

interface ClientFactoryInterface
{
    public static function create(
        array $options,
        string $wsdlProviderClass = PassThroughWsdlProvider::class,
        ?ClientClassMapCollectionInterface $classMap = null,
        ?ClientTypeConverterCollectionInterface $typeMap = null,
        ?Transport $transport = null,
        ?MetadataOptions $metadataOptions = null
    ): ClientInterface;

    public static function getClientClassName(): string;

    public static function getDefaultClientClassMap(): ClientClassMapCollectionInterface;

    public static function getDefaultClientTypeMap(): ClientTypeConverterCollectionInterface;
}
