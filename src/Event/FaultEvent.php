<?php

namespace Webmasterskaya\Soap\Base\Event;

use Webmasterskaya\Soap\Base\Exception\SoapException;

class FaultEvent
{
    public function __construct(
        protected SoapException $soapException,
        protected RequestEvent $requestEvent
    ) {
    }

    public function getSoapException(): SoapException
    {
        return $this->soapException;
    }

    public function getRequestEvent(): RequestEvent
    {
        return $this->requestEvent;
    }
}
