<?php

namespace Lite\Config;

use Lite\App;

class Config
{

    public static array $configs = [];

    public static function load()
    {
        $files = glob(App::$root . "/config/*.php");
        foreach ($files as $file) {
            $key = explode(".", basename($file))[0];
            self::$configs[$key] = require $file;
        }
    }
    
    public static function get(string $config, mixed $default = null)
    {
        $keys = explode(".", $config);
        $array_search = self::$configs;
        foreach ($keys as $key) {
            if (!array_key_exists($key, $array_search))
                return $default;
            $array_search = $array_search[$key];
        }
        return $array_search;
    }
}
