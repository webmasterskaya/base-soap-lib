<?php


namespace Webmasterskaya\Soap\Base\Helper;

class ClassHelper
{
    /**
     * @param object|string $class
     * @param string $interface
     * @return bool
     */
    public static function shouldImplement($class, string $interface): bool
    {
        $interfaces = class_implements($class);

        return isset($interfaces[$interface]);
    }

    /**
     * @param object|string $class
     * @param string $interface
     * @return bool
     */
    public static function shouldNotImplement($class, string $interface): bool
    {
        return !static::shouldImplement($class, $interface);
    }

    /**
     * @param object|string $class
     * @param object|string $instance
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
     * @param object|string $class
     * @param object|string $instance
     * @return bool
     */
    public static function shouldNotBeAnInstanceOf($class, $instance): bool
    {
        return !static::shouldBeAnInstanceOf($class, $instance);
    }
}
