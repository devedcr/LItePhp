<?php

namespace Lite\Validation\Rules;

class Number implements ValidationRule
{

    public function message()
    {
        return "The field must be numeric";
    }

    public function isValid(string $field, array $data)
    {
        return is_numeric($data[$field]);
    }
}
