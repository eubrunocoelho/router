<?php

require __DIR__ . '/vendor/autoload.php';

$routes = require __DIR__ . '/config/routes.php';

$method = $_SERVER['REQUEST_METHOD'];
$path = $_SERVER['PATH_INFO'] ?? '/';

use Src\lib\Router;
use Src\lib\Dispatcher;

$router = new Router($method, $path);
$dispatcher = new Dispatcher($router, $routes);
$dispatcher->dispatch();
