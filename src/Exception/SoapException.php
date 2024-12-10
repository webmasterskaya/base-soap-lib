<?php

namespace Webmasterskaya\Soap\Base\Exception;

use Throwable;

class SoapException extends RuntimeException
{
    /**
     * @param   \Throwable  $throwable
     *
     * @return SoapException
     */
    public static function fromThrowable(Throwable $throwable): self
    {
        return new self($throwable->getMessage(), (int)$throwable->getCode(), $throwable);
    }
}
