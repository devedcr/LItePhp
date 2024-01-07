<?php

return [
    "boot" => [
        Lite\Provider\ServerServiceProvider::class,
        Lite\Provider\SessionServiceProvider::class,
        Lite\Provider\ViewServiceProvider::class,
        Lite\Provider\DatabaseServiceProvider::class,
        App\Providers\AuthenticationServiceProvider::class,
        App\Providers\HashServiceProvider::class
    ],
    "runtime" => [
        App\Providers\RouteServiceProvider::class,
    ]
];
