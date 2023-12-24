<?php

namespace Lite\Validation\Rules;

interface ValidationRule
{
    public function message();
    public function isValid(string $field, array $data);
}
