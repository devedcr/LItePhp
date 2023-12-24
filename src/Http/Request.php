<?php

namespace Lite\Http;

use Lite\Server\IServer;
use Lite\Validation\Validator;

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

    private array $headers;


    public function __construct(IServer $server)
    {
        $this->uri = $server->requestUri();
        $this->data = $server->requestPost();
        $this->query = $server->requestParam();
        $this->method = $server->requestMethod();
        $this->setHeaders($server->getHeaders());
    }

    public function headers(string $header = null): array | string |null
    {
        if (is_null($header)) {
            return $this->headers;
        }
        return $this->headers[strtolower($header)] ?? null;
    }

    public function setHeaders(array $headers): self
    {
        foreach ($headers as $header => $value) {
            $this->headers[strtolower($header)] = $value;
        }
        return $this;
    }

    /**
     * Getter URI Request
     * @return string
     */
    public function getUri(): string
    {
        return $this->uri;
    }

    /**
     * Getter Methods Request
     * @return HttpMethod
     */
    public function getMethod(): HttpMethod
    {
        return $this->method;
    }

    public function validate(array $validations, $messages = []): array
    {
        $validator = new Validator($this->data);
        return $validator->validate($validations, $messages);
    }
}
