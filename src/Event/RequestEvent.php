<?php

namespace Webmasterskaya\Soap\Base\Event;

use Webmasterskaya\Soap\Base\Type\RequestInterface;

class RequestEvent
{
    public function __construct(
        protected string $method,
        protected RequestInterface $request
    ) {
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getRequest(): RequestInterface
    {
        return $this->request;
    }
}
