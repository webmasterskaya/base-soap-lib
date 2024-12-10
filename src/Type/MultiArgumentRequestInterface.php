<?php

namespace Webmasterskaya\Soap\Base\Type;

interface MultiArgumentRequestInterface extends RequestInterface
{
    /**
     * @return array
     */
    public function getArguments(): array;
}
