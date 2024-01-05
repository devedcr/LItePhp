<?php

namespace Lite\Provider;

use Lite\Container\Container;
use Lite\Session\Session;
use Lite\Session\SessionNative;

class SessionServiceProvider implements IServiceProvider
{
    public function register_service()
    {
        match (config("session.storage")) {
            "native" => Container::singleton(Session::class, fn () => new Session(new SessionNative()))
        };
    }
}
