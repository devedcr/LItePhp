<?php

namespace Lite;

use Lite\HttpMethod;

class Router
{
    private array $methods = [];

    public function __construct()
    {
        foreach (HttpMethod::cases() as $method) {
            $this->methods[$method->value] = [];
        }
    }

    public function get(string $uri, callable $callable)
    {
        $this->methods[HttpMethod::GET->value][$uri] = $callable;
    }

    public function post(string $uri, callable $callable)
    {
        $this->methods[HttpMethod::POST->value][$uri] = $callable;
    }

    public function put(string $uri, callable $callable)
    {
        $this->methods[HttpMethod::PUT->value][$uri] = $callable;
    }

    public function delete(string $uri, callable $callable)
    {
        $this->methods[HttpMethod::DELETE->value][$uri] = $callable;
    }

    public function resolve(string $uri, string $method)
    {
        $action = $this->methods[$method][$uri] ?? null;
        if (is_null($action)) throw new HttpNotFoundException();
        return $action;
    }
}
