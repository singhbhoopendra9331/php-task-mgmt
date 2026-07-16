<?php

use app\controllers\HomeController;
use app\controllers\TaskController;

$router->get('/', [HomeController::class, 'index']);

$router->get('/tasks', [TaskController::class, 'index']);

$router->post('/tasks', [TaskController::class, 'store']);