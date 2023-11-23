<?php

namespace Lite\Test;

use Lite\Route;
use PHPUnit\Framework\TestCase;

class RouteTest extends TestCase
{
    public function routesWithoutParameters()
    {
        return [
            ["/test"],
            ["/test/case"],
            ["/"],
            ["/test/large/route/press"],
            ["/test/one/two"],
            ["/test/xyz"],
        ];
    }

    /**
     * @dataProvider routesWithoutParameters
     */
    public function test_match__route_without_parameter(string $uri)
    {
        $route = new Route($uri, fn () => "test");
        $this->assertEquals($route->match($uri."/"), true);
        $this->assertEquals($route->match("/123"), false);
        $this->assertEquals($route->match("/test/edcr"), false);
        $this->assertEquals($route->match("/case/tedds/xd"), false);
    }

    public function routesWithParameters()
    {
        return [
            ["/test/{param}", "/test/1", ["param" => 1]],
            ["/test/{p}/nested", "/test/string/nested", ["p" => "string"]],
            ["/nest/ted/{ed}/{tu}/ed", "/nest/ted/1/string/ed", ["ed" => 1, "tu" => "string"]],
            ["/nest/{ed}/{tu}/{qr}", "/nest/string/2/1", ["ed" => "string", "tu" => 2, "qr" => 1]],
            ["/nest/ted/p/d/e/{x}", "/nest/ted/p/d/e/string", ["x" => "string"]],
        ];
    }

    /**
     * @dataProvider routesWithParameters
     */
    public function test_match_route_with_parameter(string $uri_defined, string $uri_requested)
    {
        $route = new Route($uri_defined, fn () => "test");
        $this->assertEquals($route->match($uri_requested), true);
    }

    /**
     * @dataProvider routesWithParameters
     */
    public function test_match_route_with_parameter_expected(string $uri_defined, string $uri_requested, array $expected)
    {
        $route = new Route($uri_defined, fn () => "test");
        $this->assertEquals($route->hasParameters(), true);
        $this->assertEquals($expected, $route->parseParameters($uri_requested));
    }
}
