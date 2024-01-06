<?php

namespace App\Providers;

use Lite\App;
use Lite\Provider\IServiceProvider;

class RouteServiceProvider implements IServiceProvider
{
    public function register_service()
    {
        foreach (glob(App::$root . "/route/*.php") as $file) {
            require_once $file;
        }
    }
}
