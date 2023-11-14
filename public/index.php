<?php
require_once "../vendor/autoload.php";

use Lite\HttpNotFoundException;
use Lite\Router;

$router = new Router();

$router->get("/hello", function () {
    return "get:hello";
});

$router->post("/hello", function () {
    return "post:hello";
});

try {
    $action = $router->resolve($_SERVER["REQUEST_URI"], $_SERVER["REQUEST_METHOD"]);
    var_dump($action());
    die();
} catch (HttpNotFoundException $e) {
    echo $e->getMessage();
}
