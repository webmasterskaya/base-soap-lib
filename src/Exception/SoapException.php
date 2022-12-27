<?php

declare(strict_types=1);

namespace Webmasterskaya\Soap\Base\Exception;

use Throwable;

final class SoapException extends RuntimeException
{
    /**
     *
     * @return SoapException
     */
    public static function fromThrowable(Throwable $throwable): self
    {
        return new self($throwable->getMessage(), (int)$throwable->getCode(), $throwable);
    }
}
