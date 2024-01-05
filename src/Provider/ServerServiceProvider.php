<?php

namespace Lite\Provider;

use Lite\Container\Container;
use Lite\Provider\IServiceProvider;
use Lite\Server\IServer;
use Lite\Server\ServerNative;

class ServerServiceProvider implements IServiceProvider
{
    public function register_service()
    {
        return Container::singleton(IServer::class, ServerNative::class);
    }
}
