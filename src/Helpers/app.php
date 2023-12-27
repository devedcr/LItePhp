<?php

use Lite\App;
use Lite\Container\Container;

function app(string $class = App::class)
{
    return Container::singleton($class);
}

function snake_case(string $pascalCase): string
{
    return strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $pascalCase));
}
