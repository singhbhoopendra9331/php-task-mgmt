<?php

namespace App\Core;

abstract class BaseController
{
    protected function view(
        string $view,
        array $data = [],
        string $layout = 'dashboard'
    ): void {
        Response::view($view, $data, $layout);
    }

    protected function json(
        mixed $data,
        int $status = 200
    ): void {
        Response::json($data, $status);
    }

    protected function redirect(string $url): void
    {
        Response::redirect($url);
    }

    protected function abort(int $status): void
    {
        match ($status) {
            403 => Response::forbidden(),
            404 => Response::notFound(),
            default => Response::status($status),
        };
    }
}