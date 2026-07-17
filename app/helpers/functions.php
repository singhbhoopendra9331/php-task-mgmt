<?php

/**
 * Renders a view file with the given data
 * @param string $view
 * @param array $data
 * @return void
 */
function view(string $view, array $data = [], string $layout = 'dashboard')
{
    extract($data);

    ob_start();

    require ABS_PATH . "/views/{$view}.php";

    $content = ob_get_clean();

    require ABS_PATH . "/views/layouts/{$layout}.php";
}

/**
 * Render shared pagination controls.
 */
function pagination(?\App\Core\Paginator $paginator): void
{
    if (!$paginator) {
        return;
    }

    require ABS_PATH . '/views/partials/pagination.php';
}
