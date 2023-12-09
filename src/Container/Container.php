<?php

namespace Lite\Container;

use Lite\Server\ServerNative;

class Container
{
    private static array $instances = [];

    public static function singleton(string $class)
    {
        if(!isset(Container::$instances[$class])){
            Container::$instances[$class] = new $class();
        }
        return Container::$instances[$class];
    }

}