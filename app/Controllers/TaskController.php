<?php

namespace App\Controllers;

use App\Models\Task;
use App\Core\Request;
use App\Core\Response;
use App\Core\BaseController;
use App\Core\PaginatesRequests;
use App\Services\AuthService;

class TaskController extends BaseController
{
    use PaginatesRequests;

    public function index(Request $request)
    {
        if (!(new AuthService())->check()) {
            $this->redirect('/login');
        }

        $paginator = (new Task())->paginate(array_merge(
            $this->paginationOptions($request, '/dashboard/tasks', 10),
            [
                'order_by' => 'created_at',
                'direction' => 'DESC',
            ]
        ));

        Response::view('dashboard/tasks/index', [
            'title' => 'Tasks',
            'subtitle' => 'Manage project tasks and assignments.',
            'tasks' => $paginator->items,
            'paginator' => $paginator,
        ], 'dashboard');
    }

    public function show(Request $request, int $id)
    {
        if (!(new AuthService())->check()) {
            $this->redirect('/login');
        }

        Response::view('dashboard/tasks/index', [
            'title' => 'Tasks',
            'subtitle' => 'Manage project tasks and assignments.',
            'tasks' => [],
            'paginator' => null,
        ], 'dashboard');
    }
}
