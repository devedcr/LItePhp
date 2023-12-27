<?php

namespace Lite\Database;

use Lite\Database\Driver\IDatabaseDriver;

abstract class Model
{
    protected ?string $table = null;
    protected string $primary_key = "id";
    protected array $attributes = [];

    public static IDatabaseDriver $db;

    public static function setDatabaseDriver(IDatabaseDriver $db)
    {
        self::$db = $db;
    }

    public function __construct()
    {
        if (is_null($this->table)) {
            $this->table =  snake_case(static::class) . "s";
        }
    }

    public function __set($name, $value)
    {
        $this->attributes[$name] = $value;
    }

    public function __get($name)
    {
        return $this->attributes[$name];
    }

    public function save()
    {
        $fields = implode(",", array_keys($this->attributes));
        $prepareValues = implode(",", array_fill(0, count($this->attributes), "?"));
        self::$db->statement("INSERT INTO {$this->table}($fields) values ($prepareValues);", array_values($this->attributes));
    }
}
