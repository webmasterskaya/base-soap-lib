<?php

namespace Webmasterskaya\Soap\Base\Exception;

class UnexpectedConfigurationException extends RuntimeException
{
    public static function expectedTypeButGot(string $configurationKey, string $expectedType, $value): self
    {
        return new self(
            sprintf(
                'Invalid configuration. Expected value of option %s to be of type %s but got %s.',
                $configurationKey,
                $expectedType,
                gettype($value)
            )
        );
    }
}