<?php

require "../bootstrap/app.php";

use App\Core\Request;
use App\Core\Router;

$request = new Request();
$router = new Router();

require ABS_PATH . '/routes/web.php';

$router->dispatch($request);
