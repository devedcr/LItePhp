<?php

namespace Lite\Container;

use Lite\Server\ServerNative;

class Container
{
    public static array $instances = [];

    public static function singleton(string $class, string|callable|null $build = null)
    {
        if (!array_key_exists($class, Container::$instances)) {
            return match (true) {
                is_null($build) => Container::$instances[$class] = new $class(),
                is_string($build) => Container::$instances[$class] = new $build(),
                is_callable($build) => Container::$instances[$class] = $build()
            };
        }
        return Container::$instances[$class];
    }
}
