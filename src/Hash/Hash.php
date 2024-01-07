<?php

namespace Lite\Hash;

class Hash
{
    public static function make(string $password): string
    {
        return  app(IHash::class)->hash($password);
    }

    public static function verify(string $password, string $hash): bool
    {
        return  app(IHash::class)->verify($password, $hash);
    }
}
