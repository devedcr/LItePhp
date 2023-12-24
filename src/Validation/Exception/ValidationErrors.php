<?php

namespace Lite\Validation\Exception;

use Lite\Exception\LiteException;

class ValidationErrors extends LiteException
{
    public function __construct(protected array $errors)
    {
    }
    public function getErrors()
    {
        return $this->errors;
    }
}
