<?php

namespace Lite\Database\Migration;

use Lite\Database\DB;
use Lite\Database\Driver\IDatabaseDriver;

class Migrator
{
    public function __construct(
        private string $directionCreate,
        private string $directionTemplate,
        private IDatabaseDriver $driver
    ) {
        $this->directionCreate = $directionCreate;
        $this->directionTemplate = $directionTemplate;
        $this->driver = $driver;
    }


    public function migrate()
    {
        $files = glob("{$this->directionCreate}/*.php");
        $this->driver->statement("CREATE TABLE IF NOT EXISTS migrations( name varchar(255) );");
        $tables  = $this->driver->statement("SELECT * FROM migrations");
        $names_files = [];
        foreach ($tables as $table)
            $names_files[$table["name"]] = "";

        foreach ($files as $path_file) {
            $filename = basename($path_file);
            if (!array_key_exists($filename, $names_files)) {
                $file = require $path_file;
                $file->up();
                $this->driver->statement("INSERT INTO migrations values('{$filename}')");
                $this->log("migrated {$filename}");
            }
        }
        $this->log("Migration Fnished");
    }

    public function log(string $message)
    {
        print $message . PHP_EOL;
    }

    public function make(string $commnad)
    {
        if (preg_match("/create_(.*)_table/", $commnad, $matches)) {
            $file = file_get_contents("$this->directionTemplate/Migration.php");
            $file = str_replace("@table", strtoupper($matches[1]), $file);
            file_put_contents("$this->directionCreate/{$this->generate_id()}_{$matches[0]}.php", $file);
            return;
        }
        if (preg_match("/(add|remove)_(.*)_(to|from)_(.*)_table/", $commnad, $matches)) {
            return;
        }
    }

    public function generate_id()
    {
        $date = date("Y_m_d");
        $number_secuence = count(glob("$this->directionCreate/*.php"));
        while (strlen($number_secuence) < 6)
            $number_secuence = "0" . $number_secuence;

        return "{$date}_{$number_secuence}";
    }
}
