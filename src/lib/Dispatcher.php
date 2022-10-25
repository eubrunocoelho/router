<?php

namespace Src\lib;

use Src\lib\Router;
use Closure;

class Dispatcher
{
    private object $router;

    public function __construct(Router $router, $routes)
    {
        $this->router = $router;
        $this->loadRoutes($routes);
    }

    private function loadRoutes($routes)
    {
        foreach ($routes as $route)
            $this->router->add($route['method'], $route['route'], $route['action']);
    }

    private function loadController($controller, $action)
    {
        if (class_exists($controller))
            $controller = new $controller;
        else
            return false;

        if (method_exists($controller, $action))
            echo $controller->$action($this->router->getParams());
        else
            return false;
    }

    public function dispatch()
    {
        $result = $this->router->handler();

        if (!$result) {
            echo '404 - NOT FOUND.';
            die();
        }

        if (!($result instanceof Closure) && is_string($result)) {
            $result = explode('::', $result);
            $controller = $result[0] ?? null;
            $action = $result[1] ?? null;

            $this->loadController($controller, $action);
            die();
        } elseif ($result instanceof Closure) {
            echo $result($this->router->getParams());
            die();
        }

        return false;
    }
}
