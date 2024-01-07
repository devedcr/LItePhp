<?php

namespace App\Providers;

use Lite\Auth\AuthenticationSession;
use Lite\Auth\IAuthenticable;
use Lite\Container\Container;
use Lite\Provider\IServiceProvider;

class AuthenticationServiceProvider implements IServiceProvider
{
    public function register_service()
    {
        match (config("auth.method", "session")) {
            "session" =>  Container::singleton(IAuthenticable::class, AuthenticationSession::class)
        };
    }
}
