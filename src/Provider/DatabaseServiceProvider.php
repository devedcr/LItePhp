<?php

namespace Lite\Provider;

use Lite\Container\Container;
use Lite\Database\Driver\IDatabaseDriver;
use Lite\Database\Driver\PdoDriver;

class DatabaseServiceProvider implements IServiceProvider
{
    public function register_service()
    {
        match (config("database.connection", "mysql")) {
            "mysql", "pgsql" => Container::singleton(IDatabaseDriver::class, PdoDriver::class),
        };
    }
}
