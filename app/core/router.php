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
        $uri = $request->uri();

        $route = $this->routes[$method][$uri] ?? null;

        if (!$route) {
            http_response_code(404);
            echo "404 Not Found";
            return;
        }

        if (is_callable($route)) {
            $route();
            return;
        }

        [$controller, $action] = $route;

        $controller = new $controller();

        $controller->$action($request);
    }
}