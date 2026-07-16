<?php

use App\Controllers\AuthController;
use App\Controllers\HomeController;
use App\Controllers\TaskController;

$router->get('/', [HomeController::class, 'index']);

$router->get('/tasks', [TaskController::class, 'index']);

$router->post('/tasks', [TaskController::class, 'store']);

$router->get('/login', [AuthController::class, 'showLogin']);

$router->post('/login', [AuthController::class, 'login']);

$router->post('/logout', [AuthController::class, 'logout']);