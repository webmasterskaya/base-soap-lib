<?php

declare(strict_types=1);

namespace Webmasterskaya\Soap\Base\Exception;

use RuntimeException as SPLRuntimeException;

/**
 * Exception thrown when there is an error during program execution
 */
final class RuntimeException extends SPLRuntimeException implements ExceptionInterface
{
}
