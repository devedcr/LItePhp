<?php

namespace Lite;

use Closure;

class Route
{
    public string $regex_param_name;
    public string $regex_param_value;
    public string $uri;
    public Closure $action;
    public array $parameter;

    public function __construct(string $uri, Closure $action)
    {
        $this->uri = $uri;
        $this->action = $action;
        $this->regex_param_name = '/\{([a-zA-Z]+)\}/';
        $this->regex_param_value = "#^" . preg_replace($this->regex_param_name, '(\S+)', $this->uri) . "$#";
        preg_match_all($this->regex_param_name, $this->uri, $param_name);
        $this->parameter = $param_name[1];
    }

    public function action()
    {
        return $this->action;
    }

    public function match(string $uri_value)
    {
        return preg_match($this->regex_param_value, $uri_value);
    }

    public function parseParameters(string $uri_value)
    {
        preg_match($this->regex_param_value, $uri_value, $values);
        unset($values[0]);
        return array_combine($this->parameter, $values);
    }

    public function hasParameters()
    {
        return  count($this->parameter) > 0;
    }
}
