<?php

namespace Lite\Database;

class DB
{
    public static function statement(string $query, $bind = [])
    {
        return app()->database->statement($query, $bind);
    }
}
