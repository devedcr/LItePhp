<?php

namespace Lite\Validation;

use Lite\Validation\Rules\Email;
use Lite\Validation\Rules\Number;
use Lite\Validation\Rules\Required;
use Lite\Validation\Rules\RequiredWhen;
use Lite\Validation\Rules\ValidationRule;

class Rules
{
    public static function email()
    {
        return new Email();
    }
    public static function number()
    {
        return new Number();
    }
    public static function required()
    {
        return new Required();
    }

    public static function required_when(string $field, string $operator, int $value)
    {
        return new RequiredWhen($field, $operator, $value);
    }

    public static function name(string $str): string
    {
        $classValidates = explode("\\", $str);
        return strtolower($classValidates[count($classValidates) - 1]);
    }

    public static function from(string $str): ValidationRule
    {
        $parts = explode(":", $str);
        $function = strtolower($parts[0]);
        $params = explode(",", $parts[1]);
        return self::$function(...$params);
    }
}
