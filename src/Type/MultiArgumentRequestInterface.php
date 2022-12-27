<?php


namespace Webmasterskaya\Soap\Base\Type;

interface MultiArgumentRequestInterface extends RequestInterface
{
    public function getArguments(): array;
}
