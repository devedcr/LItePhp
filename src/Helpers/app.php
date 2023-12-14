<?php

use Lite\App;
use Lite\Container\Container;

function app(string $class = App::class)
{
    return Container::singleton($class);
}
