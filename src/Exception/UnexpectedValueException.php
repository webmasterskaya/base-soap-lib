<?php

namespace Webmasterskaya\Soap\Base\Exception;

use UnexpectedValueException as SPLUnexpectedValueException;

/**
 * Exception thrown when provided arguments are invalid
 */
class UnexpectedValueException extends SPLUnexpectedValueException implements ExceptionInterface
{
}
