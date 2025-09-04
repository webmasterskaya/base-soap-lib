<?php

namespace Webmasterskaya\Soap\Base;

use Psr\EventDispatcher\EventDispatcherInterface;
use Webmasterskaya\Soap\Base\Soap\EngineOptions;

interface ClientFactoryInterface
{
    /**
     * @param non-empty-string $wsdl
     */
    public static function create(
        string $wsdl,
        ?EngineOptions $options = null,
        ?EventDispatcherInterface $eventDispatcher = null,
    ): ClientInterface;
}
