<?php

namespace Lite\Server;

use Lite\Http\HttpMethod;
use Lite\Http\Response;

class ServerNative implements IServer
{
    public function requestUri(): string
    {
        return  parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
    }

    public function requestMethod(): HttpMethod
    {
        return HttpMethod::from($_SERVER["REQUEST_METHOD"]);
    }

    public function requestPost(): array
    {
        return  $_POST;
    }

    public function requestParam(): array
    {
        return $_GET;
    }
    public function sendResponse(Response $response): void
    {
        //clean header default of way forced
        header("content-type: test");
        header_remove("content-type");

        http_response_code($response->status());
        if ($response->content() != null) {
            header("content-length: " . (strlen($response->content())));
            header("content-type: text/html; charset=UTF-8");
        }
        foreach ($response->headers() as $content => $value) {
            header("{$content}: {$value}");
        }
        echo $response->content();
    }
}
