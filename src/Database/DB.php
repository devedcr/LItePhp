<?php

namespace Lite\Database;

use Lite\Database\Driver\IDatabaseDriver;
use Lite\Database\Driver\PdoDriver;

class DB
{
    public static function statement(string $query, $bind = [])
    {
        return app(IDatabaseDriver::class)->statement($query, $bind);
    }
}
