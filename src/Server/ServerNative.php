<?php

namespace Lite\Server;

use Lite\Http\HttpMethod;
use Lite\Http\Response;

/**
 * @implements IServer
 */
class ServerNative implements IServer
{
    /**
     * @inheritDoc
     */
    public function requestUri(): string
    {
        return  parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
    }

    /**
     * @inheritDoc
     */
    public function requestMethod(): HttpMethod
    {
        return HttpMethod::from($_SERVER["REQUEST_METHOD"]);
    }

    /**
     * @inheritDoc
     */
    public function requestPost(): array
    {
        return  $_POST;
    }

    public function requestJson(): array
    {
        return json_decode(trim(file_get_contents("php://input")), true) ?? [];
    }

    /**
     * @inheritDoc
     */
    public function requestParam(): array
    {
        return $_GET;
    }

    public function getHeaders(): array
    {
        return getallheaders();
    }

    /**
     * @inheritDoc
     */
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
