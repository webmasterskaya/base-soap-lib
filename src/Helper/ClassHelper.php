<?php

namespace Webmasterskaya\Soap\Base\Helper;

class ClassHelper
{
    /**
     * @param   object|string  $class
     * @param   string         $interface
     *
     * @return bool
     */
    public static function shouldImplement(object|string $class, string $interface): bool
    {
        $interfaces = class_implements($class);

        return isset($interfaces[$interface]);
    }

    /**
     * @param   object|string  $class
     * @param   string         $interface
     *
     * @return bool
     */
    public static function shouldNotImplement(object|string $class, string $interface): bool
    {
        return !static::shouldImplement($class, $interface);
    }

    /**
     * @param   object|string  $class
     * @param   object|string  $instance
     *
     * @return bool
     */
    public static function shouldBeAnInstanceOf(object|string $class, object|string $instance): bool
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
     * @param   object|string  $class
     * @param   object|string  $instance
     *
     * @return bool
     */
    public static function shouldNotBeAnInstanceOf(object|string $class, object|string $instance): bool
    {
        return !static::shouldBeAnInstanceOf($class, $instance);
    }
}
