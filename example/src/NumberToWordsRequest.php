<?php

namespace Webmasterskaya\Soap\Base\Example;

readonly class NumberToWordsRequest implements \Webmasterskaya\Soap\Base\Type\RequestInterface
{
    public function __construct(
        private int $ubiNum,
    ) {
    }

    public function getUbiNum(): int
    {
        return $this->ubiNum;
    }
}
