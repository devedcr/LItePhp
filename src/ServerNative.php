<?php

namespace Lite;


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
}
