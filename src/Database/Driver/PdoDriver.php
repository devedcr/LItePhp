<?php

namespace Lite\Database\Driver;

use PDO;

class PdoDriver implements IDatabaseDriver
{
    protected PDO $db;

    public function connect(string $protocol, string $dbname, string $host, int $port, string $user, string $pass)
    {
        $dsn = "$protocol:host=$host;port=$port;dbname=$dbname;";
        $this->db = new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    }

    public function statement(string $query, array $bind = []): mixed
    {
        $prepare = $this->db->prepare($query);
        $prepare->execute($bind);
        return $prepare->fetchAll(PDO::FETCH_ASSOC);
    }

    public function close()
    {
        $db = null;
    }
}
