<?php

require "../bootstrap/app.php";

use app\core\Request;
use app\core\Router;

$request = new Request();
$router = new Router();

require ABS_PATH . '/routes/web.php';

$router->dispatch($request);
