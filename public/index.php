<?php

use Lite\Http\HttpNotFoundException;
use Lite\Http\Request;
use Lite\Http\Response;
use Lite\Routing\Router;
use Lite\Server\ServerNative;

require_once "../vendor/autoload.php";

$router = new Router();

$router->get("/hello", function () {
    return Response::json(["code" => "test"])->setStatus(201);
});

$router->get("/test/{id}/preuba/{title}", function () {
    return Response::text("test param");
});

$router->post("/hello", function () {
    return Response::text("hello post");
});

$router->get("/redirect", function () {
    return Response::redirect("/hello");
});

$server = new ServerNative();
try {
    $action = $router->resolve(new Request($server));
    $response = $action();
    $server->sendResponse($response);
} catch (HttpNotFoundException $e) {
    $server->sendResponse(Response::text("Not Found")->setStatus(404));
}
