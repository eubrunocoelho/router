<?php

namespace Src\lib;

class Router
{
    private $routes, $params = [];
    private string $method, $path;

    public function __construct($method, $path)
    {
        $this->method = $method;
        $this->path = $path;
    }

    public function add($method, $route, $action)
    {
        $this->routes[$method][$route] = $action;
    }

    public function getParams()
    {
        return $this->params;
    }

    public function handler()
    {
        if (empty($this->routes[$this->method]))
            return false;

        if (isset($this->routes[$this->method][$this->path]))
            return $this->routes[$this->method][$this->path];

        foreach ($this->routes[$this->method] as $route => $action) {
            $result = $this->checkURL($route, $this->path);

            if ($result >= 1)
                return $action;
        }

        return false;
    }

    private function checkURL($route, $path)
    {
        $route = str_replace('/', '\/', $route);
        preg_match_all('/\{([^{}}]*)\}/', $route, $matches);

        foreach ($matches[0] as $key => $variables) {
            $replacement = '([a-zA-Z0-9\-\_\ ]+)';
            $route = str_replace($variables, $replacement, $route);
        }

        $route = preg_replace('/{([a-zA-Z]+)}/', '([a-zA-Z0-9+])', $route);
        $result = preg_match('/^' . $route  . '$/', $path, $variables);

        $params = [];

        for ($i = 1; $i < count($variables); $i++) {
            array_push($params, $variables[$i]);
        }

        $this->params = $params;

        return $result;
    }
}
