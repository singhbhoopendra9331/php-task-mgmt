<?php

namespace app\controllers;

use app\models\Task;
use app\core\Response;
use app\core\BaseController;

class HomeController extends BaseController
{
    public function index()
    {
        $tasks = new Task();
        Response::view('home', [
            'title' => 'Tasks | Dashboard',
            'tasks' => $tasks
        ]);
    }
}