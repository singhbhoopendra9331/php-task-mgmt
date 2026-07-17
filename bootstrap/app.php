<?php

define('ABS_PATH', dirname(__DIR__));

require ABS_PATH . '/app/helpers/functions.php';
require ABS_PATH . '/app/helpers/env.php';
require ABS_PATH . '/app/helpers/file.php';
require ABS_PATH . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(ABS_PATH);
$dotenv->load();

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}