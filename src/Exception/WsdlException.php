<?php

namespace Webmasterskaya\Soap\Base\Exception;

class WsdlException extends RuntimeException implements ExceptionInterface
{
    /**
     * @param string $path
     *
     * @return WsdlException
     */
    public static function notFound(string $path): self
    {
        return new self(
            sprintf('The WSDL could not be loaded from location: %s', $path)
        );
    }

    /**
     * @param \Throwable $exception
     *
     * @return WsdlException
     */
    public static function fromException(\Throwable $exception): self
    {
        return new self(
            $exception->getMessage(),
            $exception->getCode(),
            $exception
        );
    }
}