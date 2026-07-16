<?php

namespace App\Core;

class Router
{
    private array $routes = [];

    /**
     * Summary of get
     * @param string $uri
     * @param array|callable $action
     * @return void
     */
    public function get(string $uri, array|callable $action): void
    {
        $this->addRoute('GET', $uri, $action);
    }

    public function post(string $uri, array|callable $action): void
    {
        $this->addRoute('POST', $uri, $action);
    }

    public function put(string $uri, array|callable $action): void
    {
        $this->addRoute('PUT', $uri, $action);
    }

    public function delete(string $uri, array|callable $action): void
    {
        $this->addRoute('DELETE', $uri, $action);
    }

    public function options(string $uri, array|callable $action): void
    {
        $this->addRoute('OPTIONS', $uri, $action);
    }

    public function patch(string $uri, array|callable $action): void
    {
        $this->addRoute('PATCH', $uri, $action);
    }

    private function addRoute(string $method, string $uri, array|callable $action): void
    {
        $this->routes[$method][$uri] = $action;
    }

    /**
     * Summary of dispatch
     * @param Request $request
     * @return void
     */
    public function dispatch(Request $request): void
    {
        $method = $request->method();
        $uri = trim($request->uri(), '/');

        $routes = $this->routes[$method] ?? [];

        foreach ($routes as $route => $action) {

            $route = trim($route, '/');

            $pattern = preg_replace(
                '/\{[^\/]+\}/',
                '([^/]+)',
                $route
            );

            $pattern = "#^{$pattern}$#";

            if (preg_match($pattern, $uri, $matches)) {

                array_shift($matches);

                if (is_callable($action)) {
                    $action(...$matches);
                    return;
                }

                [$controller, $method] = $action;

                $controller = new $controller();

                $controller->$method($request, ...$matches);

                return;
            }
        }

        http_response_code(404);
        echo "404 Not Found";
    }
}