<?php

use Lite\Http\Response;

function view(string $viewName, array $params = [], string $layout = null): Response
{
    return Response::view($viewName, $params, $layout);
}

function redirect(string $uri): Response
{
    return Response::redirect($uri);
}

function text(string $text)
{
    return Response::text($text);
}

function json(array $data): Response
{
    return Response::json($data);
}
