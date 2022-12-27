<?php

declare(strict_types=1);

namespace Webmasterskaya\Soap\Base\Type;

interface MultiArgumentRequestInterface extends RequestInterface
{
    public function getArguments(): array;
}
