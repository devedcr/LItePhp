<?php

namespace Lite\Validation\Rules;

class RequiredWhen implements ValidationRule
{
    private $field;
    private $operator;
    private $value;

    public function __construct(string $field, string $operator, int $value)
    {
        $this->field = $field;
        $this->operator = $operator;
        $this->value = $value;
    }

    public function message()
    {
        return "The field {$this->field} not is {$this->operator} than {$this->value}";
    }

    public function isValid(string $field, array $data)
    {
        match ($this->operator) {
            "==" => fn () => (int)($data[$this->field]) == $this->value,
            ">" => fn () => (int)($data[$this->field]) > $this->value,
            ">=" => fn () => (int)($data[$this->field]) >= $this->value,
            "<" => fn () => (int)($data[$this->field]) < $this->value,
            "<=" => fn () => (int)($data[$this->field]) <= $this->value,
        };
    }
}
