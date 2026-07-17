<?php

use App\Controllers\AuthController;
use App\Controllers\HomeController;
use App\Controllers\MediaController;
use App\Controllers\ProjectController;
use App\Controllers\TaskController;

$router->get('/', [HomeController::class, 'index']);

$router->get('/dashboard', [HomeController::class, 'dashboard']);

$router->get('/dashboard/projects', [ProjectController::class, 'index']);

$router->get('/dashboard/projects/create', [ProjectController::class, 'create']);

$router->post('/dashboard/projects', [ProjectController::class, 'store']);

$router->get('/dashboard/projects/{id}/edit', [ProjectController::class, 'edit']);

$router->post('/dashboard/projects/{id}', [ProjectController::class, 'update']);

$router->post('/dashboard/projects/{id}/delete', [ProjectController::class, 'destroy']);

$router->get('/dashboard/tasks', [TaskController::class, 'index']);

$router->post('/dashboard/tasks', [TaskController::class, 'store']);

$router->get('/login', [AuthController::class, 'showLogin']);

$router->post('/login', [AuthController::class, 'login']);

$router->get('/register', [AuthController::class, 'showRegister']);

$router->post('/register', [AuthController::class, 'register']);

$router->post('/logout', [AuthController::class, 'logout']);

$router->get('/dashboard/media', [MediaController::class, 'index']);

$router->post('/dashboard/media', [MediaController::class, 'store']);

$router->get('/dashboard/media/{id}/download', [MediaController::class, 'download']);

$router->post('/dashboard/media/{id}/delete', [MediaController::class, 'destroy']);

$router->get('/dashboard/tasks/{id}/media', [MediaController::class, 'forTask']);

$router->post('/dashboard/tasks/{id}/media', [MediaController::class, 'attachToTask']);

$router->post('/dashboard/tasks/{taskId}/media/{mediaId}/detach', [MediaController::class, 'detachFromTask']);
