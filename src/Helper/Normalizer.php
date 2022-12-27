<?php

namespace Webmasterskaya\Soap\Base\Helper;

use Webmasterskaya\Soap\Base\Exception\RuntimeException;
use function in_array;
use function strlen;

class Normalizer
{
    /**
     * @var array
     */
    private static $normalizations = [
        'any' => 'mixed',
        'anytype' => 'mixed',
        'long' => 'int',
        'short' => 'int',
        'datetime' => '\\DateTimeInterface',
        'date' => '\\DateTimeInterface',
        'boolean' => 'bool',
        'decimal' => 'float',
        'double' => 'float',
        'integer' => 'int',
        'string' => 'string',
        'self' => 'self',
        'callable' => 'callable',
        'iterable' => 'iterable',
        'array' => 'array',
    ];

    /**
     * @var array
     * @see https://secure.php.net/manual/en/reserved.keywords.php
     * @see https://www.php.net/manual/en/reserved.other-reserved-words.php
     */
    private static $reservedKeywords = [
        '__halt_compiler',
        'abstract',
        'and',
        'array',
        'as',
        'break',
        'callable',
        'case',
        'catch',
        'class',
        'clone',
        'const',
        'continue',
        'declare',
        'default',
        'die',
        'do',
        'echo',
        'else',
        'elseif',
        'empty',
        'enddeclare',
        'endfor',
        'endforeach',
        'endif',
        'endswitch',
        'endwhile',
        'eval',
        'exit',
        'extends',
        'final',
        'finally',
        'for',
        'foreach',
        'function',
        'global',
        'goto',
        'if',
        'implements',
        'include',
        'include_once',
        'instanceof',
        'insteadof',
        'interface',
        'isset',
        'list',
        'namespace',
        'new',
        'or',
        'print',
        'private',
        'protected',
        'public',
        'require',
        'require_once',
        'return',
        'static',
        'switch',
        'throw',
        'trait',
        'try',
        'unset',
        'use',
        'var',
        'while',
        'xor',
        'yield',
        'void',

        // Other reserved words:
        'int',
        'true',
        'false',
        'null',
        'void',
        'bool',
        'float',
        'string',
        'object',
        'resource',
        'mixed',
        'numeric'
    ];


    private static function normalizeReservedKeywords(string $name, string $suffix): string
    {
        if (!in_array(strtolower($name), self::$reservedKeywords, true)) {
            return $name;
        }

        return $name . $suffix;
    }


    public static function normalizeNamespace(string $namespace): string
    {
        return trim(str_replace('/', '\\', $namespace), '\\');
    }

    /**
     * Convert a word to camelCase or CamelCase (not changing first part!)
     *
     *
     */
    private static function camelCase(string $word, string $regexp): string
    {
        $parts = array_filter(preg_split($regexp, $word));
        $keepUnchanged = array_shift($parts);
        $parts = array_map('ucfirst', $parts);
        array_unshift($parts, $keepUnchanged);

        $implode = implode('', $parts);

        if (!empty($implode)) {
            return $implode;
        }

        throw new RuntimeException('Failed to convert the string');
    }


    public static function normalizeMethodName(string $method): string
    {
        // Methods cant start with a number in PHP - move it after text
        $method = preg_replace('{^([0-9]*)(.*)}', '$2$1', $method);
        if (is_numeric($method)) {
            $method = 'call' . $method;
        }

        // Methods cant be named after reserved keywords.
        $method = self::normalizeReservedKeywords($method, 'Call');

        return lcfirst(self::camelCase($method, '{[^a-z0-9_]+}i'));
    }


    public static function normalizeClassname(string $name): string
    {
        $name = self::normalizeReservedKeywords($name, 'Type');

        return ucfirst(self::camelCase($name, '{[^a-z0-9]+}i'));
    }


    public static function normalizeClassnameInFQN(string $fqn): string
    {
        if (self::isKnownType($fqn)) {
            return $fqn;
        }

        $className = self::getClassNameFromFQN($fqn);

        return substr($fqn, 0, -1 * strlen($className)) . self::normalizeClassname($className);
    }


    public static function normalizeProperty(string $property): string
    {
        return self::camelCase($property, '{[^a-z0-9_]+}i');
    }


    public static function normalizeDataType(string $type): string
    {
        $searchType = strtolower($type);

        return array_key_exists($searchType, self::$normalizations) ? self::$normalizations[$searchType] : $type;
    }

    public static function isKnownType(string $type): bool
    {
        return in_array($type, self::$normalizations, true);
    }


    public static function generatePropertyMethod(string $prefix, string $property): string
    {
        return strtolower($prefix) . ucfirst(self::normalizeProperty($property));
    }


    public static function getClassNameFromFQN(string $name): string
    {
        $arr = explode('\\', $name);

        $className = array_pop($arr);

        if (!empty($className)) {
            return $className;
        }

        throw new RuntimeException('Failed to get class name from FQN');
    }


    public static function getCompleteUseStatement(string $useName, string $useAlias = null): string
    {
        $use = $useName;
        if (null !== $useAlias && $useAlias !== '') {
            $use .= ' as ' . $useAlias;
        }

        return $use;
    }
}
