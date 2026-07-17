<?php

namespace App\Core;

class Response
{
    public static function view(
        string $view,
        array $data = [],
        string $layout = 'dashboard'
    ): void {
        extract($data);

        ob_start();

        require ABS_PATH . "/views/{$view}.php";

        $content = ob_get_clean();

        require ABS_PATH . "/views/layouts/{$layout}.php";
    }

    public static function json(
        mixed $data,
        int $status = 200
    ): void {
        http_response_code($status);

        header('Content-Type: application/json');

        echo json_encode($data);

        exit;
    }

    public static function redirect(string $url): void
    {
        header("Location: {$url}");
        exit;
    }

    public static function status(int $code): void
    {
        http_response_code($code);
    }

    public static function notFound(): void
    {
        self::status(404);

        echo "404 Not Found";

        exit;
    }

    public static function forbidden(): void
    {
        self::status(403);

        echo "403 Forbidden";

        exit;
    }

    public static function noContent(): void
    {
        http_response_code(204);
        exit;
    }
}