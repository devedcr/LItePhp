<?php

namespace Lite\Validation;

use Lite\Validation\Exception\ValidationErrors;

class Validator
{
    public function __construct(protected array $data)
    {
    }

    public function validate(array $validations, array $messages = []): array
    {
        $errors = [];
        foreach ($validations as $field => $rules) {
            if (!is_array($rules))
                $rules = [$rules];

            $errorField = [];
            foreach ($rules as $rule) {
                if(is_string($rule)){
                    $rule = Rules::from($rule);
                }
                if (!$rule->isValid($field, $this->data)) {
                    $error_message = $messages[$rule::class] ?? $rule->message();
                    $errorField[Rules::name($rule::class)] = $error_message;
                }
            }
            if (count($errorField) > 0)
                $errors[$field] = $errorField;
        }
        return (count($errors) > 0)  ?  throw new ValidationErrors($errors) : [];
    }
}
