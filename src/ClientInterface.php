<?php

namespace Webmasterskaya\Soap\Base;

use Webmasterskaya\Soap\Base\Caller\CallerInterface;

interface ClientInterface
{
    public function __construct(CallerInterface $caller);
}
