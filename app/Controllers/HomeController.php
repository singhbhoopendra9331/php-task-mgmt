<?php

namespace App\Controllers;

use App\Models\Task;
use App\Core\Response;
use App\Core\BaseController;

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