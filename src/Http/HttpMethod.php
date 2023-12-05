<?php
namespace Lite\Http;

/**
 * ENUM case HTTP METHODS
 */
enum HttpMethod: string
{
    case GET = "GET";
    case POST = "POST";
    case PUT = "PUT";
    case DELETE = "DELETE";
}
