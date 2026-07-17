<?php

namespace App\Controllers;

use App\Core\BaseController;
use App\Core\PaginatesRequests;
use App\Core\Request;
use App\Models\Project;
use App\Services\AuthService;
use App\Services\ProjectService;

class ProjectController extends BaseController
{
    use PaginatesRequests;

    private ProjectService $projects;
    private AuthService $auth;

    public function __construct()
    {
        $this->projects = new ProjectService();
        $this->auth = new AuthService();
    }

    public function index(Request $request): void
    {
        $this->requireAuth();

        $paginator = $this->projects->paginate($this->paginationOptions(
            $request,
            '/dashboard/projects',
            10
        ));

        $this->view('dashboard/projects/index', [
            'title' => 'Projects',
            'subtitle' => 'Create and manage your projects.',
            'projects' => $paginator->items,
            'paginator' => $paginator,
            'error' => $request->query('error'),
            'success' => $request->query('success'),
        ], 'dashboard');
    }

    public function create(Request $request): void
    {
        $this->requireAuth();

        $this->view('dashboard/projects/create', [
            'title' => 'New Project',
            'subtitle' => 'Add a project to your workspace.',
            'project' => $this->emptyProject(),
            'statuses' => Project::STATUSES,
            'error' => $request->query('error'),
        ], 'dashboard');
    }

    public function store(Request $request): void
    {
        $user = $this->requireAuth();
        $input = $request->all();

        $result = $this->projects->create($input, (int) $user['id']);

        if (!$result['ok']) {
            $this->view('dashboard/projects/create', [
                'title' => 'New Project',
                'subtitle' => 'Add a project to your workspace.',
                'project' => array_merge($this->emptyProject(), $input),
                'statuses' => Project::STATUSES,
                'error' => $result['error'],
            ], 'dashboard');
            return;
        }

        $this->redirect(
            '/dashboard/projects/' . (int) $result['project']['id'] .
            '?success=' . urlencode('Project created successfully.')
        );
    }

    public function show(Request $request, string $id): void
    {
        $this->requireAuth();

        $details = $this->projects->findWithDetails((int) $id);

        if (!$details) {
            $this->abort(404);
        }

        $this->view('dashboard/projects/show', [
            'title' => $details['project']['name'],
            'subtitle' => 'Project details and related work.',
            'project' => $details['project'],
            'members' => $details['members'],
            'tasks' => $details['tasks'],
            'error' => $request->query('error'),
            'success' => $request->query('success'),
        ], 'dashboard');
    }

    public function edit(Request $request, string $id): void
    {
        $this->requireAuth();

        $project = $this->projects->find((int) $id);

        if (!$project) {
            $this->abort(404);
        }

        $this->view('dashboard/projects/edit', [
            'title' => 'Edit Project',
            'subtitle' => 'Update project details.',
            'project' => $project,
            'statuses' => Project::STATUSES,
            'error' => $request->query('error'),
        ], 'dashboard');
    }

    public function update(Request $request, string $id): void
    {
        $this->requireAuth();
        $input = $request->all();
        $projectId = (int) $id;

        $result = $this->projects->update($projectId, $input);

        if (!$result['ok']) {
            if ($result['error'] === 'Project not found.') {
                $this->abort(404);
            }

            $this->view('dashboard/projects/edit', [
                'title' => 'Edit Project',
                'subtitle' => 'Update project details.',
                'project' => array_merge(['id' => $projectId], $input),
                'statuses' => Project::STATUSES,
                'error' => $result['error'],
            ], 'dashboard');
            return;
        }

        $this->redirect(
            '/dashboard/projects/' . $projectId .
            '?success=' . urlencode('Project updated successfully.')
        );
    }

    public function destroy(Request $request, string $id): void
    {
        $this->requireAuth();

        if (!$this->projects->delete((int) $id)) {
            $this->redirect('/dashboard/projects?error=' . urlencode('Project not found.'));
        }

        $this->redirect('/dashboard/projects?success=' . urlencode('Project deleted.'));
    }

    private function requireAuth(): array
    {
        if (!$this->auth->check()) {
            $this->redirect('/login');
        }

        return $this->auth->user();
    }

    private function emptyProject(): array
    {
        return [
            'name' => '',
            'description' => '',
            'status' => 'planning',
            'start_date' => '',
            'end_date' => '',
        ];
    }
}
