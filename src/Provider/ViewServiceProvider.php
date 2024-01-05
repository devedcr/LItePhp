<?php

namespace Lite\Provider;

use Lite\Container\Container;
use Lite\View\IViewEngine;
use Lite\View\ViewEngine;

class ViewServiceProvider implements IServiceProvider
{
    public function register_service()
    {
        match (config("view.engine", "lite")) {
            "lite" => Container::singleton(IViewEngine::class, fn () => new ViewEngine(config("view.path")))
        };
    }
}
