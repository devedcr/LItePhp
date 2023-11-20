<?php
require_once "../vendor/autoload.php";

use Lite\HttpNotFoundException;
use Lite\Router;

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
    $action = $router->resolve($_SERVER["REQUEST_URI"], $_SERVER["REQUEST_METHOD"]);
    echo $action()."\n";
} catch (HttpNotFoundException $e) {
    echo "Not Found\n";
}
