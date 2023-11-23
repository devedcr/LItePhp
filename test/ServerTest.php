<?php

namespace Lite\Test;

use Lite\HttpMethod;
use Lite\IServer;

class ServerTest implements IServer
{
    private string $uri;
    private HttpMethod $method;

    public function __construct(string $uri, HttpMethod $method)
    {
        $this->uri = $uri;
        $this->method = $method;
    }

    public function requestUri(): string
    {
        return $this->uri;
    }

    public function requestMethod(): HttpMethod
    {
        return $this->method;
    }

    public function requestPost(): array
    {
        return [];
    }

    public function requestParam(): array
    {
        return [];
    }
}
