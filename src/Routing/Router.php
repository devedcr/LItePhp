<?php

namespace Lite\Routing;

use Closure;
use Lite\Http\HttpMethod;
use Lite\Http\HttpNotFoundException;
use Lite\Http\Request;

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
     * @return void
     */
    private function register_method(HttpMethod $method, string $uri, Closure $action)
    {
        $this->routes[$method->value][] = new Route($uri, $action);
    }
    
    /**
     * Setter Route Get
     * @param string $uri
     * @param Closure $action
     * @return void
     */
    public function get(string $uri, Closure $action)
    {
        $this->register_method(HttpMethod::GET, $uri, $action);
    }

    /**
     * Setter Route Post
     * @param string $uri
     * @param Closure $action
     * @return void
     */
    public function post(string $uri, Closure $action)
    {
        $this->register_method(HttpMethod::POST, $uri, $action);
    }

    /**
     * Setter Routes Put
     * @param string $uri
     * @param Closure $action
     * @return void
     */
    public function put(string $uri, Closure $action)
    {
        $this->register_method(HttpMethod::PUT, $uri, $action);
    }
    
    /**
     * Setter Routes Delete
     * @param string $uri
     * @param Closure $action
     * @return void
     */
    public function delete(string $uri, Closure $action)
    {
        $this->register_method(HttpMethod::DELETE, $uri, $action);
    }
    
    /**
     * Resolve Request Route
     * @param Request $request
     * @return Closure
     */
    public function resolve(Request $request): Closure
    {
        foreach ($this->routes[$request->getMethod()->value] as $route) {
            if ($route->match($request->getUri()))
                return $route->action();
        }
        throw new HttpNotFoundException();
    }
}
