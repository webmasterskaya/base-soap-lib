<?php

declare(strict_types=1);

namespace Webmasterskaya\Soap\Base\Exception;

use InvalidArgumentException as SPLInvalidArgumentException;

/**
 * Exception thrown when one or more method arguments are invalid
 */
final class InvalidArgumentException extends SPLInvalidArgumentException implements ExceptionInterface
{
}
