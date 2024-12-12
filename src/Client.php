<?php

namespace Webmasterskaya\Soap\Base;

use Webmasterskaya\Soap\Base\Caller\CallerInterface;
use Webmasterskaya\Soap\Base\Type\RequestInterface;
use Webmasterskaya\Soap\Base\Type\ResultInterface;

final readonly class Client implements ClientInterface
{
    public function __construct(
        private CallerInterface $caller
    ) {
    }

    public function call(string $method, RequestInterface $request): ResultInterface
    {
        return ($this->caller)($method, $request);
    }
}
