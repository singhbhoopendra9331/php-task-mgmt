<?php

require_once __DIR__ . '/bootstrap/app.php';

use app\core\Migration;

$migration = new Migration();

$command = $argv[1] ?? 'migrate';

switch ($command) {
    case 'migrate':
        $migration->migrate();
        break;

    case 'rollback':
        $migration->rollback();
        break;

    case 'status':
        $migration->status();
        break;

    default:
        echo "Unknown command: {$command}" . PHP_EOL;
        exit(1);
}