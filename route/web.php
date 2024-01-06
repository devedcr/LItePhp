<?php

use Lite\Routing\Route;

Route::get("/form", fn () => view("form"));

Route::get("/json", fn () => json([
    "test" => "ok"
]));
