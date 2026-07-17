<?php

namespace App\Middleware;

use App\Middleware\Middleware;

class AuthMiddleware implements Middleware
{
    /**
     * Summary of handle
     * @return void
     */
    public function handle()
    {
        if (!isset($_SESSION['user'])) {
            header('Location: /login');
            exit;
        }
    }
}