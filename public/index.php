<?php

require_once "../vendor/autoload.php";

use Lite\App;
use Lite\Container\Container;
use Lite\Http\Response;
use Lite\Routing\Route;

$app = Container::singleton(App::class);

Route::get("/hello", function () {
    return Response::json(["code" => "test"])->setStatus(201);
});

Route::get("/test/{id}/preuba/{title}", function () {
    return Response::text("test param");
});

$app->router()->post("/hello", function () {
    return Response::text("hello post");
});

Route::get("/redirect", function () {
    return Response::redirect("/hello");
});

$app->run();
