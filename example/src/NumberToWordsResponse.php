<?php

namespace Webmasterskaya\Soap\Base\Example;

use Webmasterskaya\Soap\Base\Type\ResultInterface;

readonly class NumberToWordsResponse implements ResultInterface
{
    public function __construct(
        private string $NumberToWordsResult,
    ) {
    }

    public function getNumberToWordsResult(): string
    {
        return $this->NumberToWordsResult;
    }
}
