<?php

namespace Lite\Server;

use Lite\Http\HttpMethod;
use Lite\Http\Response;

/**
 * IServer interface Scheme
 */
interface IServer
{
    /**
     * The Server return uri
     * @return string
     */
    public function requestUri(): string;

    /**
     * The Server return Method
     * @return HttpMethod
     */
    public function requestMethod(): HttpMethod;

    /**
     * The Server return Post Data
     * @return array
     */
    public function requestPost(): array;

    /**
     * The Server return Get Query Params
     * @return array
     */
    public function requestParam(): array;

    /**
     * The Server send Resonse
     * @param Response $response
     * @return void
     */
    public function sendResponse(Response $response): void;

    public function getHeaders(): array;
}
