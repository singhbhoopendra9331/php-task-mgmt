<?php

namespace App\Controllers;

use App\Models\Task;
use App\Core\Response;
use App\Core\BaseController;
use App\Services\AuthService;

class HomeController extends BaseController
{
    public function index()
    {
        $this->redirect('/dashboard');
    }

    public function dashboard()
    {
        if (!(new AuthService())->check()) {
            $this->redirect('/login');
        }

        $task = new Task();

        Response::view('dashboard/index', [
            'title' => 'Dashboard',
            'tasks' => $task->all(),
        ], 'dashboard');
    }
}
