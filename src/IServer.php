<?php

namespace Lite;
use Lite\HttpMethod;

interface IServer
{
    public function requestUri(): string;
    public function requestMethod(): HttpMethod;
    public function requestPost(): array;
    public function requestParam(): array;
}
