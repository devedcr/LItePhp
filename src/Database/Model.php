<?php

namespace Lite\Database;

use Error;
use Lite\Database\Driver\IDatabaseDriver;

abstract class Model
{
    protected ?string $table = null;
    protected string $primary_key = "id";
    protected array $fillable = [];
    protected array $hidden = [];
    protected array $attributes = [];

    public static IDatabaseDriver $db;

    public static function setDatabaseDriver(IDatabaseDriver $db)
    {
        self::$db = $db;
    }

    public function __construct()
    {
        if (is_null($this->table)) {
            $parts = explode("\\", static::class);
            $this->table =  snake_case($parts[count($parts) - 1]) . "s";
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

    public function __sleep()
    {
        foreach ($this->attributes as $key => $value) {
            if (in_array($key, $this->hidden)) {
                unset($this->attributes[$key]);
            }
        }
        return  array_keys(get_object_vars($this));
    }

    public function save(): mixed
    {
        $fields = implode(",", array_keys($this->attributes));
        $prepareValues = implode(",", array_fill(0, count($this->attributes), "?"));
        self::$db->statement("INSERT INTO {$this->table}($fields) values ($prepareValues);", array_values($this->attributes));
        return $this;
    }

    public function toArray()
    {
        return array_filter($this->attributes, fn ($attr) => !in_array($attr, $this->hidden));
    }

    public function setAttributes(array $pattributes): void
    {
        foreach ($pattributes as $key => $value) {
            $this->__set($key, $value);
        }
    }

    public static function create(array $data)
    {
        $model = new static();
        $data_persist = [];
        foreach (array_values($model->fillable) as $key) {
            if (!isset($data[$key])) {
                throw new Error("Model {$model->table} need field {$key} of field fillable");
            }
            $data_persist[$key] = $data[$key];
        }
        if (count($data_persist) == 0)
            throw new Error("Add field fillable of Model {$model->table}");
        $model->setAttributes($data_persist);
        return $model->save();
    }

    public static function find(string|int $id)
    {
        $model = new static();
        $rows = $model::$db->statement("SELECT * FROM {$model->table} WHERE {$model->primary_key}=?", [$id]);
        if (count($rows) == 0)
            return null;
        return $rows[0];
    }

    public static function parseModel(array $attributes): static
    {
        $static = new static();
        $static->setAttributes($attributes);
        return $static;
    }

    public static function parseModels(array $dataModels)
    {
        $array_model = [];
        foreach ($dataModels as $dataModel)
            $array_model[] = self::parseModel($dataModel);
        return $array_model;
    }

    public static function all()
    {
        $model = new static();
        $rows = $model::$db->statement("SELECT * FROM {$model->table}");
        return $rows;
    }
    public static function where(string $filed, mixed $value)
    {
        $model = new static();
        $rows = $model::$db->statement("SELECT * FROM {$model->table} where $filed=?", [$value]);
        return $rows;
    }
}
