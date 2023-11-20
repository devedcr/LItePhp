<?php

namespace Lite;

use Closure;
use Lite\HttpMethod;

class Router
{
    private array $routes = [];

    public function __construct()
    {
        foreach (HttpMethod::cases() as $method) {
            $this->routes[$method->value] = [];
        }
    }

    private function register_method(HttpMethod $method, string $uri, Closure $action)
    {
        $this->routes[$method->value][] = new Route($uri, $action);
    }

    public function get(string $uri, Closure $action)
    {
        $this->register_method(HttpMethod::GET, $uri, $action);
    }

    public function post(string $uri, Closure $action)
    {
        $this->register_method(HttpMethod::POST, $uri, $action);
    }

    public function put(string $uri, Closure $action)
    {
        $this->register_method(HttpMethod::PUT, $uri, $action);
    }

    public function delete(string $uri, Closure $action)
    {
        $this->register_method(HttpMethod::DELETE, $uri, $action);
    }

    public function resolve(string $uri, string $method)
    {
        foreach ($this->routes[$method] as $route) {
            if ($route->match($uri)) 
                return $route->action();
        }
        throw new HttpNotFoundException();
    }
}
