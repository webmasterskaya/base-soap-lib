<?php

namespace Webmasterskaya\Soap\Base;

use Psr\EventDispatcher\EventDispatcherInterface;
use Soap\Engine\Transport;
use Soap\ExtSoapEngine\ExtSoapOptions;
use Webmasterskaya\Soap\Base\Caller\EngineCaller;
use Webmasterskaya\Soap\Base\Caller\EventDispatchingCaller;
use Webmasterskaya\Soap\Base\Soap\DefaultEngineFactory;
use Webmasterskaya\Soap\Base\Soap\Metadata\MetadataOptions;

final class ClientFactory implements ClientFactoryInterface
{
    public static function create(
        string $wsdl,
        ?ExtSoapOptions $options = null,
        ?Transport $transport = null,
        ?MetadataOptions $metadataOptions = null,
        ?EventDispatcherInterface $eventDispatcher = null
    ): ClientInterface {
        $options ??= ExtSoapOptions::defaults($wsdl, []);

        $engine = DefaultEngineFactory::create($options, $transport, $metadataOptions);

        $caller = new EngineCaller($engine);

        if (isset($eventDispatcher)) {
            $caller = new EventDispatchingCaller($caller, $eventDispatcher);
        }

        return new Client($caller);
    }
}
