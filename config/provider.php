<?php

return [
    "boot" => [
        Lite\Provider\ServerServiceProvider::class,
        Lite\Provider\SessionServiceProvider::class,
        Lite\Provider\ViewServiceProvider::class,
        Lite\Provider\DatabaseServiceProvider::class,
    ],
    "runtime" => [
        App\Providers\RouteServiceProvider::class
    ]
];
