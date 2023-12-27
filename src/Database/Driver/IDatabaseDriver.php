<?php

namespace Lite\Database\Driver;

interface IDatabaseDriver
{
    public function connect(string $protocol, string $dbname, string $host, int $port, string $user, string $pass);
    public function statement(string $query, array $bind = []): mixed;
    public function close();
}
