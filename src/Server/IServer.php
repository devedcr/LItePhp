<?php

namespace Lite\Server;

use Lite\Http\HttpMethod;
use Lite\Http\Response;

interface IServer
{
    public function requestUri(): string;
    public function requestMethod(): HttpMethod;
    public function requestPost(): array;
    public function requestParam(): array;
    public function sendResponse(Response $response): void;
}
