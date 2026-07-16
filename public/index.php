<?php

define('ABS_PATH', dirname(__DIR__));

use app\core\Request;
use app\core\Router;

$request = new Request();
$router = new Router();

require ABS_PATH . '/routes/web.php';

$router->dispatch($request);
