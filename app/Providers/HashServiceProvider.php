<?php

namespace App\Providers;

use Lite\Container\Container;
use Lite\Hash\Bcrypt;
use Lite\Hash\IHash;
use Lite\Provider\IServiceProvider;

class HashServiceProvider implements IServiceProvider
{
    public function register_service()
    {
        match (config("hash.encode", "bcrypt")) {
            "bcrypt" => Container::singleton(IHash::class, Bcrypt::class)
        };
    }
}
