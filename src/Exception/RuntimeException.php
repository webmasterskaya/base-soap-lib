<?php

namespace Webmasterskaya\Soap\Base\Exception;

use RuntimeException as SPLRuntimeException;

/**
 * Exception thrown when there is an error during program execution
 */
class RuntimeException extends SPLRuntimeException implements ExceptionInterface
{
}
