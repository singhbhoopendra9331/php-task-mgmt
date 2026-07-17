<?php

namespace App\Middleware;

use App\Middleware\Middleware;

class AuthMiddleware implements Middleware
{
    public function handle(callable $next)
    {
        if (!isset($_SESSION['user'])) {
            header('Location: /login');
            exit;
        }

        if ($_SESSION['user']['role'] !== 'admin') {
            http_response_code(403);
            exit('Forbidden');
        }

        return $next();
    }
}