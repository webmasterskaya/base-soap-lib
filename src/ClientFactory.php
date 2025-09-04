<?php

namespace Webmasterskaya\Soap\Base;

use Psr\EventDispatcher\EventDispatcherInterface;
use Webmasterskaya\Soap\Base\Caller\EngineCaller;
use Webmasterskaya\Soap\Base\Caller\EventDispatchingCaller;
use Webmasterskaya\Soap\Base\Soap\DefaultEngineFactory;
use Webmasterskaya\Soap\Base\Soap\EngineOptions;

final class ClientFactory implements ClientFactoryInterface
{
    /**
     * @param non-empty-string $wsdl
     */
    public static function create(
        string $wsdl,
        ?EngineOptions $options = null,
        ?EventDispatcherInterface $eventDispatcher = null,
    ): ClientInterface {
        $options ??= EngineOptions::defaults($wsdl);

        $engine = DefaultEngineFactory::create($options);

        $caller = new EngineCaller($engine);

        if (isset($eventDispatcher)) {
            $caller = new EventDispatchingCaller($caller, $eventDispatcher);
        }

        return new Client($caller);
    }
}
