<?php

require_once "../vendor/autoload.php";

use Lite\App;
use Lite\Routing\Route;

$app = App::bootstrap();

Route::get("/hello", function () {
    return json(["code" => "test"])->setStatus(201);
});

Route::get("/test/{id}/preuba/{title}", function () {
    return text("test param");
});

$app->router()->post("/hello", function () {
    return text("hello post");
});

Route::get("/redirect", function () {
    return redirect("/hello");
});

Route::get("/html", function () {
    return view("welcome", ["name" => "eduardo", "email" => "ed@ed.com"]);
});

$app->run();
