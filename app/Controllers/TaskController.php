<?php

namespace App\Controllers;

use App\Models\Task;
use App\Core\Request;
use App\Core\Response;
use App\Core\BaseController;
use App\Services\AuthService;

class TaskController extends BaseController
{
    public function index()
    {
        if (!(new AuthService())->check()) {
            $this->redirect('/login');
        }

        $task = new Task();

        Response::view('dashboard/tasks/index', [
            'title' => 'Tasks',
            'tasks' => $task->all(),
        ], 'dashboard');
    }

    public function show(Request $request, int $id)
    {
        if (!(new AuthService())->check()) {
            $this->redirect('/login');
        }

        Response::view('dashboard/tasks/index', [
            'title' => 'Tasks',
            'tasks' => [],
        ], 'dashboard');
    }
}
