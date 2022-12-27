<?php

declare(strict_types=1);

namespace Webmasterskaya\Soap\Base\Helper;

final class ClassHelper
{
    public static function shouldImplement($class, $interface)
    {
        $interfaces = class_implements($class);

        return isset($interfaces[$interface]);
    }

    public static function shouldNotImplement($class, $interface)
    {
        return !static::shouldImplement($class, $interface);
    }

    public static function shouldBeAnInstanceOf($class, $instance)
    {
        if (is_object($class)) {
            return $class instanceof $instance;
        }

        if ($class === $instance) {
            return true;
        }

        $parents         = class_parents($class);
        $parents[$class] = $class;

        return isset($parents[$instance]);
    }

    public static function shouldNotBeAnInstanceOf($class, $instance)
    {
        return !static::shouldBeAnInstanceOf($class, $instance);
    }
}
