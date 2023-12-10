<?php

require_once "../vendor/autoload.php";

use Lite\App;
use Lite\Http\Middleware;
use Lite\Http\Request;
use Lite\Http\Response;
use Lite\Routing\Route;

$app = App::bootstrap();

class AuthMiddleware implements Middleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!$request->headers("Authorization")) {
            return Response::text("Token Authorizaton not found");
        }
        return $next();
    }
}

class TestMiddleware implements Middleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!$request->headers("test")) {
            return Response::text("Token test not found");
        }
        return $next();
    }
}


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
