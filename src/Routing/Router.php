<?php

namespace Lite\Routing;

use Closure;
use Lite\Http\HttpMethod;
use Lite\Http\HttpNotFoundException;
use Lite\Http\Request;
use Lite\Http\Response;
use Middleware;

/**
 * Router class Management Routes
 */
class Router
{
    /**
     * List of routes
     * @var array<string,Route>
     */
    private array $routes = [];

    public function __construct()
    {
        foreach (HttpMethod::cases() as $method) {
            $this->routes[$method->value] = [];
        }
    }

    /**
     * Register all types of routes
     * @param HttpMethod $method
     * @param string $uri
     * @param Closure $action
     * @return Route
     */
    private function register_method(HttpMethod $method, string $uri, Closure $action): Route
    {
        $route = new Route($uri, $action);
        $this->routes[$method->value][] = $route;
        return $route;
    }

    /**
     * Setter Route Get
     * @param string $uri
     * @param Closure $action
     * @return Route
     */
    public function get(string $uri, Closure $action): Route
    {
        return $this->register_method(HttpMethod::GET, $uri, $action);
    }

    /**
     * Setter Route Post
     * @param string $uri
     * @param Closure $action
     * @return Route
     */
    public function post(string $uri, Closure $action): Route
    {
        $route = $this->register_method(HttpMethod::POST, $uri, $action);
        return $route;
    }

    /**
     * Setter Routes Put
     * @param string $uri
     * @param Closure $action
     * @return Route
     */
    public function put(string $uri, Closure $action): Route
    {
        return $this->register_method(HttpMethod::PUT, $uri, $action);
    }

    /**
     * Setter Routes Delete
     * @param string $uri
     * @param Closure $action
     * @return Route
     */
    public function delete(string $uri, Closure $action): Route
    {
        return $this->register_method(HttpMethod::DELETE, $uri, $action);
    }


    /**
     * Resolve Request Route
     * @param Request $request
     * @return Closure
     */
    public function resolveAction(Request $request): Closure
    {
        foreach ($this->routes[$request->getMethod()->value] as $route) {
            if ($route->match($request->getUri()))
                return $route->action();
        }
        throw new HttpNotFoundException();
    }

    public function resolveRoute(Request $request): Route
    {
        foreach ($this->routes[$request->getMethod()->value] as $route) {
            if ($route->match($request->getUri()))
                return $route;
        }
        throw new HttpNotFoundException();
    }

    public function chain_middeware(Request $request, array $middlewares): Response
    {
        if (count($middlewares) == 1) {
            return ($middlewares[0])($request);
        }
        return $middlewares[0]->handle(
            $request,
            fn () => $this->chain_middeware($request, array_slice($middlewares, 1))
        );
    }

    public function resolve(Request $request): Response
    {
        $route = $this->resolveRoute($request);
        if ($route->hasMiddleware()) {
            return $this->chain_middeware($request, $route->middlewares);
        }
        return ($route->action)($request);
    }
}
