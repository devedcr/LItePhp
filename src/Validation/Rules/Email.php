<?php
namespace Lite\Validation\Rules;

class Email implements ValidationRule{

    public function message()
    {
        return "Email not is Valid !!!";
    }

    public function isValid(string $field, array $data)
    {
        return filter_var($data[$field],FILTER_VALIDATE_EMAIL);
    }
}