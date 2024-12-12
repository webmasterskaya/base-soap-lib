<?php

namespace Webmasterskaya\Soap\Base\Caller;

use Webmasterskaya\Soap\Base\Type\RequestInterface;
use Webmasterskaya\Soap\Base\Type\ResultInterface;

interface CallerInterface
{
    public function __invoke(string $method, RequestInterface $request): ResultInterface;
}
