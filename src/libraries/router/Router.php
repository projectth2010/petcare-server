<?php

namespace Router;

include_once '../response-json/ResponseJSON.php';

use ResponseJSON;

class Router
{
    private $routes = [];
    private $requestMethod;
    private $requestUri;

    public function __construct()
    {
        $this->requestMethod = $_SERVER['REQUEST_METHOD'];
        $this->requestUri = rtrim($_SERVER['REQUEST_URI'], '/');
    }

    public function map($method, $uri, $target)
    {
        $this->routes[] = [
            'method' => strtoupper($method),
            'uri' => rtrim($uri, '/'),
            'target' => $target
        ];
    }

    public function match()
    {
        foreach ($this->routes as $route) {
            if ($route['method'] === $this->requestMethod && $route['uri'] === $this->requestUri) {
                return [
                    'target' => $route['target'],
                    'params' => []  // Optionally add parameter parsing here if needed
                ];
            }
        }

        return false;
    }

    public function dispatch()
    {
        $match = $this->match();

        if ($match) {
            call_user_func_array($match['target'], $match['params']);
        } else {
            ResponseJSON\ResponseJSON::send([], 404, 'Not Found');
        }
    }
}
