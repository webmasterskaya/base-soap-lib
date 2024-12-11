<?php

namespace Webmasterskaya\Soap\Base\Soap;

use Soap\Engine\Engine;
use Soap\Engine\LazyEngine;
use Soap\Engine\SimpleEngine;
use Soap\Engine\Transport;
use Soap\ExtSoapEngine\AbusedClient;
use Soap\ExtSoapEngine\ExtSoapDriver;
use Soap\ExtSoapEngine\ExtSoapMetadata;
use Soap\ExtSoapEngine\ExtSoapOptions;
use Soap\ExtSoapEngine\Transport\ExtSoapClientTransport;
use Soap\ExtSoapEngine\Transport\TraceableTransport;
use Webmasterskaya\Soap\Base\Soap\ExtSoap\Metadata\Manipulators\DuplicateTypes\IntersectDuplicateTypesStrategy;
use Webmasterskaya\Soap\Base\Soap\Metadata\MetadataFactory;
use Webmasterskaya\Soap\Base\Soap\Metadata\MetadataOptions;

final class DefaultEngineFactory
{
    public static function create(
        ExtSoapOptions $options,
        ?Transport $transport = null,
        ?MetadataOptions $metadataOptions = null
    ): Engine {
        return new LazyEngine(static function () use ($options, $transport, $metadataOptions) {
            $client = AbusedClient::createFromOptions($options);

            $transport       ??= new TraceableTransport($client, new ExtSoapClientTransport($client));
            $metadataOptions ??= MetadataOptions::empty()->withTypesManipulator(
            /**
             * Ext-soap is not able to work with duplicate types
             * Therefore, we decided to combine all duplicate types into 1 big intersected type by default instead.
             **/
                new IntersectDuplicateTypesStrategy()
            );

            $driver = ExtSoapDriver::createFromClient(
                $client,
                MetadataFactory::manipulated(
                    new ExtSoapMetadata($client),
                    $metadataOptions
                )
            );

            return new SimpleEngine($driver, $transport);
        });
    }
}
