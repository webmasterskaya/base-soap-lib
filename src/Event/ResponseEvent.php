<?php

namespace Webmasterskaya\Soap\Base\Event;

use Webmasterskaya\Soap\Base\Type\ResultInterface;

class ResponseEvent
{
    public function __construct(
        protected RequestEvent $requestEvent,
        protected ResultInterface $response
    ) {
    }

    public function getRequestEvent(): RequestEvent
    {
        return $this->requestEvent;
    }

    public function getResponse(): ResultInterface
    {
        return $this->response;
    }
}
