<?php

use App\Controllers\AuthController;
use App\Controllers\HomeController;
use App\Controllers\MediaController;
use App\Controllers\TaskController;

$router->get('/', [HomeController::class, 'index']);

$router->get('/tasks', [TaskController::class, 'index']);

$router->post('/tasks', [TaskController::class, 'store']);

$router->get('/login', [AuthController::class, 'showLogin']);

$router->post('/login', [AuthController::class, 'login']);

$router->post('/logout', [AuthController::class, 'logout']);

$router->get('/media', [MediaController::class, 'index']);

$router->post('/media', [MediaController::class, 'store']);

$router->get('/media/{id}/download', [MediaController::class, 'download']);

$router->post('/media/{id}/delete', [MediaController::class, 'destroy']);

$router->get('/tasks/{id}/media', [MediaController::class, 'forTask']);

$router->post('/tasks/{id}/media', [MediaController::class, 'attachToTask']);

$router->post('/tasks/{taskId}/media/{mediaId}/detach', [MediaController::class, 'detachFromTask']);