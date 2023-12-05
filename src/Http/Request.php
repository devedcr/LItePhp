<?php

namespace Lite\Http;

use Lite\Server\IServer;

/**
 * Request Class Server
 */
class Request
{
    /**
     * uri of request
     * @var string 
     */
    private string $uri;

    /**
     * POST Data Request
     * @var array
     */
    private array $data;
    
    /**
     * Query Params Get 
     * @var array
     */
    private array $query;
    
    /**
     * Methods of Request
     * @var HttpMethod
     */
    private HttpMethod $method;


    public function __construct(IServer $server)
    {
        $this->uri = $server->requestUri();
        $this->data = $server->requestPost();
        $this->query = $server->requestParam();
        $this->method = $server->requestMethod();
    }

    /**
     * Getter URI Request
     * @return string
     */
    public function getUri():string
    {
        return $this->uri;
    }

    /**
     * Getter Methods Request
     * @return HttpMethod
     */
    public function getMethod():HttpMethod
    {
        return $this->method;
    }
}
