<?php

namespace App\Middleware;

interface Middleware
{
    /**
     * 
     * @param callable $next
     * @return void
     */
    public function handle(callable $next);
}