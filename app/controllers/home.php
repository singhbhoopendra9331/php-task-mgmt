<?php

namespace app\controllers;

use app\models\Task;

class HomeController
{
    public function index()
    {
        $task = new Task();

        view('home', [
            'title' => 'Dashboard',
            'tasks' => $task->all()
        ]);
    }
}