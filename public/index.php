<?php
require_once "../vendor/autoload.php";

use Lite\HttpNotFoundException;
use Lite\Request;
use Lite\Router;
use Lite\ServerNative;

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
