<?php

namespace Lite\Routing;

use Closure;
use Lite\App;
use Lite\Container\Container;
use Middleware;

/**
 * Route Class Join that join uri and action
 */
class Route
{
    /**
     * Regex use for Extract name uri
     * @var string
     */
    public string $regex_param_name;

    /**
     * Regex use for Extract value uri
     * @var string
     */
    public string $regex_param_value;

    /**
     * Uri defined as Route
     * @var string
     */
    public string $uri;

    /**
     * Action to Execute
     * @var Closure
     */
    public Closure $action;

    /**
     * Have the parameters of routes
     * @var array
     */
    public array $parameter;

    public array $middlewares;

    public function __construct(string $uri, Closure $action)
    {
        $this->uri = $uri;
        $this->action = $action;
        $this->regex_param_name = '/\{([a-zA-Z]+)\}/';
        $this->regex_param_value = "#^" . preg_replace($this->regex_param_name, '(\S+)', $this->uri) . "/?$#";
        preg_match_all($this->regex_param_name, $this->uri, $param_name);
        $this->parameter = $param_name[1];
        $this->middlewares = [];
    }
    /**
     *  Getter Route Action 
     * @return void
     */
    public function action()
    {
        return $this->action;
    }

    /**
     * Compare uri request with the uri defined
     * @param string $uri_value
     * @return boolean
     */
    public function match(string $uri_value): bool
    {
        return preg_match($this->regex_param_value, $uri_value);
    }

    /**
     * Generate array with the parameters
     * @param string $uri_value
     * @return void
     */
    public function parseParameters(string $uri_value)
    {
        preg_match($this->regex_param_value, $uri_value, $values);
        unset($values[0]);
        return array_combine($this->parameter, $values);
    }

    /**
     * Verfify if have parameters of routes
     * @return boolean
     */
    public function hasParameters(): bool
    {
        return  count($this->parameter) > 0;
    }

    public static function get(string $uri, Closure $action)
    {
        return app()->router()->get($uri, $action);
    }

    public static function post(string $uri, Closure $action)
    {
        return app()->router()->post($uri, $action);
    }


    public function setMiddleware(array $middlewares)
    {
        if (count($middlewares) == 0)
            return;
        $this->middlewares = array_map(fn ($middleware) => Container::singleton($middleware), $middlewares);
        $this->middlewares[] = $this->action;
    }

    public function hasMiddleware(): bool
    {
        return count($this->middlewares) > 0;
    }
}
