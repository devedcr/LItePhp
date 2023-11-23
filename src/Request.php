<?php

namespace Lite;

class Request
{
    private string $uri;
    private array $data;
    private array $query;
    private HttpMethod $method;


    public function __construct(IServer $server)
    {
        $this->uri = $server->requestUri();
        $this->data = $server->requestPost();
        $this->query = $server->requestParam();
        $this->method = $server->requestMethod();
    }

    public function getUri()
    {
        return $this->uri;
    }

    public function getMethod()
    {
        return $this->method;
    }
}
