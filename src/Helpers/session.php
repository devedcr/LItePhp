<?php

function session()
{
    return app()->session;
}


function errors(string $field): mixed
{
    $errorsField =  session()->get("_errors", [])[$field] ?? null;
    if (is_null($errorsField)) {
        return null;
    }
    return $errorsField[array_key_first($errorsField)];
}

function old(string $field): mixed
{
    return session()->get("_old", [])[$field] ?? null;
}
