<?php

namespace Router;

use ResponseJSON\ResponseJSON;

class Router
{
    private $routes = [];
    private $requestMethod;
    private $requestUri;

    public function __construct()
    {
        $this->requestMethod = $_SERVER['REQUEST_METHOD'];
        $this->requestUri = rtrim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
    }

    /**
     * Map a route to a target
     *
     * @param string $method The HTTP method (GET, POST, etc.)
     * @param string $uri The route URI
     * @param callable|array $target The target action or [Controller, method]
     */
    public function map($method, $uri, $target)
    {
        $this->routes[] = [
            'method' => strtoupper($method),
            'uri' => rtrim($uri, '/'),
            'target' => $target
        ];
    }

    /**
     * Match a request with the route
     *
     * @return array|bool The matched route or false
     */
    public function match()
    {
        foreach ($this->routes as $route) {
            // Replace placeholders like {id} with regex patterns
            $pattern = preg_replace('/\{[a-zA-Z0-9_]+\}/', '([a-zA-Z0-9_]+)', $route['uri']);
            $pattern = "@^" . $pattern . "$@D"; // Match the start and end of the URI

            if ($route['method'] === $this->requestMethod && preg_match($pattern, $this->requestUri, $matches)) {
                array_shift($matches); // Remove the full match
                return [
                    'target' => $route['target'],
                    'params' => $matches
                ];
            }
        }

        return false;
    }

    /**
     * Dispatch the route to the target
     */
    public function dispatch()
    {
        $match = $this->match();

        if ($match) {
            $target = $match['target'];
            $params = $match['params'];

            if (is_callable($target)) {
                @call_user_func_array($target, $params);
            } elseif (is_array($target)) {
                $controller = new $target[0]();  // Instantiate the controller
                $method = $target[1];

                if (method_exists($controller, $method)) {
                    @call_user_func_array([$controller, $method], $params);
                } else {
                    ResponseJSON::send([], 500, "Method $method not found in controller " . get_class($controller));
                }
            } else {
                ResponseJSON::send([], 500, 'Invalid route target');
            }
        } else {
            ResponseJSON::send([], 404, 'Not Found');
        }
    }
}
