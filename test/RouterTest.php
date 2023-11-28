<?php

namespace Lite\Test;

use Lite\Http\HttpMethod;
use Lite\Http\Request;
use Lite\Routing\Router;
use Lite\Server\IServer;
use PHPUnit\Framework\TestCase;

class RouterTest extends TestCase
{
    private function create_mock_server(string $uri, HttpMethod $method): Request
    {
        $mockServer = $this->getMockBuilder(IServer::class)->getMock();
        $mockServer->method("requestUri")->willReturn($uri);
        $mockServer->method("requestMethod")->willReturn($method);
        return new Request($mockServer);
    }

    public function test_resolve_route_action()
    {
        $uri = "/test";
        $router = new Router();
        $action = fn () => "test";
        $router->get($uri, $action);
        $this->assertEquals($action, $router->resolve($this->create_mock_server($uri, HttpMethod::GET)));
    }

    public function test_resolve_multiple_route_action()
    {
        $routes = [
            "/test" => fn () => "test",
            "/test/main" => fn () => "test",
            "/main" => fn () => "test",
            "/test/main/doc" => fn () => "test",
        ];
        $router = new Router();
        foreach ($routes as $uri => $method) {
            $router->get($uri, $method);
        }
        foreach ($routes as $uri => $method) {
            $this->assertEquals($method, $router->resolve($this->create_mock_server($uri, HttpMethod::GET)));
        }
    }
    public function test_resolve_multiple_route_with_methods_action()
    {
        $routes = [
            [HttpMethod::GET, "/test/get", fn () => "test"],
            [HttpMethod::GET, "/test", fn () => "test"],
            [HttpMethod::POST, "/test/post", fn () => "test"],
            [HttpMethod::POST, "/test", fn () => "test"],
            [HttpMethod::PUT, "/test/123", fn () => "test"],
            [HttpMethod::PUT, "/test/test/check", fn () => "test"],
            [HttpMethod::DELETE, "/api/route", fn () => "test"],
            [HttpMethod::DELETE, "/test", fn () => "test"],
        ];
        $router = new Router();
        foreach ($routes as [$method, $uri, $action]) {
            $router->{strtolower($method->value)}($uri, $action);
        }
        foreach ($routes as [$method, $uri, $action]) {
            $this->assertEquals($action, $router->resolve($this->create_mock_server($uri, $method)));
        }
    }
}
