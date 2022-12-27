<?php

declare(strict_types=1);

namespace Webmasterskaya\Soap\Base\Helper;

final class ClassHelper
{
    /**
     * @param object|string $class An object (class instance) or a string (class name)
     * @param string $interface Interface name
     * @return bool
     */
    public static function shouldImplement($class, string $interface): bool
    {
        $interfaces = class_implements($class);

        return isset($interfaces[$interface]);
    }

    /**
     * @param object|string $class An object (class instance) or a string (class name)
     * @param string $interface Interface name
     * @return bool
     */
    public static function shouldNotImplement($class, string $interface): bool
    {
        return !ClassHelper::shouldImplement($class, $interface);
    }

    /**
     * @param object|string $class An object (class instance) or a string (class name)
     * @param object|string $instance An object (class instance) or a string (class name)
     * @return bool
     */
    public static function shouldBeAnInstanceOf($class, $instance): bool
    {
        if (is_object($class)) {
            return $class instanceof $instance;
        }

        if ($class === $instance) {
            return true;
        }

        $parents = class_parents($class);
        $parents[$class] = $class;

        return isset($parents[$instance]);
    }

    /**
     * @param object|string $class An object (class instance) or a string (class name)
     * @param object|string $instance An object (class instance) or a string (class name)
     * @return bool
     */
    public static function shouldNotBeAnInstanceOf($class, $instance): bool
    {
        return !ClassHelper::shouldBeAnInstanceOf($class, $instance);
    }
}
