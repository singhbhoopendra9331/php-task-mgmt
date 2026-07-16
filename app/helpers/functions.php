<?php

/**
 * Renders a view file with the given data
 * @param string $view
 * @param array $data
 * @return void
 */
function view(string $view, array $data = [], string $layout = 'app')
{
    extract($data);

    ob_start();

    require ABS_PATH . "/views/{$view}.php";

    $content = ob_get_clean();

    require ABS_PATH . "/views/layouts/{$layout}.php";

}