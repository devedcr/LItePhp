<?php

use Lite\Http\HttpNotFoundException;
use Lite\Http\Request;
use Lite\Http\Response;
use Lite\Routing\Router;
use Lite\Server\ServerNative;

require_once "../vendor/autoload.php";

$router = new Router();

$router->get("/hello", function () {
    $response = new Response();
    $response->setStatus(201);
    $response->setHeader("Content-Type", "application/JSON");
    $response->setContent(json_encode([
        "code" => "test"
    ]));
    return $response;
});

$router->get("/test/{id}/preuba/{title}", function () {
    return "get:params";
});

$router->post("/hello", function () {
    return "post:hello";
});

try {
    $server = new ServerNative();
    $action = $router->resolve(new Request($server));
    $response = $action();
    $server->sendResponse($response);
    //echo $action() . "\n";
} catch (HttpNotFoundException $e) {
    echo "Not Found\n";
}
