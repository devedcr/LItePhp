<?php

namespace Lite\Validation\Rules;

class Required implements ValidationRule
{
    public function message()
    {
        return "The field is required !!!";
    }

    public function isValid(string $field, array $data)
    {
        if (isset($data[$field]) && $data[$field] != "")
            return true;
        
        return false;
    }
}
