<?php

namespace app\controllers;

use app\models\Task;
use app\core\Request;
use app\core\Response;
use app\core\BaseController;

class TaskController extends BaseController
{
    public function index()
    {
        $task = new Task();

        Response::view('tasks/index', [
            'title' => 'Tasks',
            'tasks' => $task->all()
        ]);
    }

    public function show(Request $request, int $id)
    { 
        // $task = Task::find($id);

        Response::view('tasks/index', [
            'title' => 'Tasks',
            'tasks' => []
            // 'tasks' => $task->all()
        ]);
    }
}