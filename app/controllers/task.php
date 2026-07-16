<?php

namespace app\controllers;

use app\models\Task;

class TaskController
{
    public function index()
    {
        $task = new Task();

        view('tasks/index', [
            'title' => 'Tasks',
            'tasks' => $task->all()
        ]);
    }
}