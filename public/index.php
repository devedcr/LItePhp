<?php

use Lite\Http\HttpNotFoundException;
use Lite\Http\Request;
use Lite\Routing\Router;
use Lite\Server\ServerNative;

require_once "../vendor/autoload.php";



$router = new Router();

$router->get("/hello", function () {
    return "get:hello";
});

$router->get("/test/{id}/preuba/{title}", function () {
    return "get:params";
});

$router->post("/hello", function () {
    return "post:hello";
});

try {
    $action = $router->resolve(new Request(new ServerNative()));
    echo $action() . "\n";
} catch (HttpNotFoundException $e) {
    echo "Not Found\n";
}
