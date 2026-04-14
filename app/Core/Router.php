<?php

namespace App\Core;

class Router
{
    private array $routes = [];
    private Container $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function add(string $method, string $uri, string $controller, string $action): void
    {
        $this->routes[] = [
            'method' => $method,
            'uri' => $uri,
            'controller' => $controller,
            'action' => $action
        ];
    }

    public function dispatch(string $uri, string $method): void
    {
        $uri = parse_url($uri, PHP_URL_PATH);

        foreach ($this->routes as $route) {
            if ($route['uri'] === $uri && $route['method'] === $method) {
                $controllerName = $route['controller'];
                $action = $route['action'];

                $controller = $this->container->get($controllerName);
                $controller->$action();
                return;
            }
        }

        http_response_code(404);
        echo "404 Not Found";
    }
}
