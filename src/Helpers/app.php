<?php

use Lite\App;
use Lite\Config\Config;
use Lite\Container\Container;

function app(string $class = App::class)
{
    return Container::singleton($class);
}

function snake_case(string $pascalCase): string
{
    return strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $pascalCase));
}

function resourcesDirectory()
{
    return App::$root . "/resources";
}
function config(string $config, $default = null)
{
    return Config::get($config, $default);
}

function env(string $variable, $default = null)
{
    return $_ENV[$variable] ?? $default;
}
