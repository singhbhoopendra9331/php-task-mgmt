<?php

namespace app\core;

class Request
{
    public function method(): string
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    public function uri(): string
    {
        return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    }

    public function body(string $key, mixed $default = null): mixed
    {
        return $_POST[$key] ?? $default;
    }

    public function query(string $key, mixed $default = null): mixed
    {
        return $_GET[$key] ?? $default;
    }

    public function all(): array
    {
        return $_POST;
    }

    public function has(string $key): bool
    {
        return isset($_POST[$key]);
    }

    public function file(string $key): ?array
    {
        return $_FILES[$key] ?? null;
    }
}