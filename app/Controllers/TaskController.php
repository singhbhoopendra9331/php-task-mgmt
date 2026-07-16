<?php

namespace App\Controllers;

use App\Models\Task;
use App\Core\Request;
use App\Core\Response;
use App\Core\BaseController;

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