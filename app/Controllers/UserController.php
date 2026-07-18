<?php

namespace App\Controllers;

use App\Core\BaseController;
use App\Core\PaginatesRequests;
use App\Core\Request;
use App\Services\AuthService;
use App\Services\UserService;

class UserController extends BaseController
{
    use PaginatesRequests;

    private UserService $users;
    private AuthService $auth;

    public function __construct()
    {
        $this->users = new UserService();
        $this->auth = new AuthService();
    }

    public function index(Request $request): void
    {
        $this->requireAuth();

        $paginator = $this->users->paginate($this->paginationOptions(
            $request,
            '/dashboard/users',
            10
        ));

        $this->view('dashboard/users/index', [
            'title' => 'Users',
            'subtitle' => 'Manage your team members.',
            'users' => $paginator->items,
            'paginator' => $paginator,
            'error' => $request->query('error'),
            'success' => $request->query('success'),
        ], 'dashboard');
    }

    public function create(Request $request): void
    {
        $this->requireAuth();

        $this->view('dashboard/users/create', [
            'title' => 'New User',
            'subtitle' => 'Add a user to your workspace.',
            'user' => $this->emptyUser(),
            'roles' => $this->users->roles(),
            'error' => $request->query('error'),
        ], 'dashboard');
    }

    public function store(Request $request): void
    {
        $this->requireAuth();
        $input = $request->all();

        $result = $this->users->create($input);

        if (!$result['ok']) {
            $this->view('dashboard/users/create', [
                'title' => 'New User',
                'subtitle' => 'Add a user to your workspace.',
                'user' => array_merge($this->emptyUser(), $input),
                'roles' => $this->users->roles(),
                'error' => $result['error'],
            ], 'dashboard');
            return;
        }

        $this->redirect(
            '/dashboard/users/' . (int) $result['user']['id'] .
            '?success=' . urlencode('User created successfully.')
        );
    }

    public function show(Request $request, string $id): void
    {
        $this->requireAuth();

        $user = $this->users->find((int) $id);

        if (!$user) {
            $this->abort(404);
        }

        $this->view('dashboard/users/show', [
            'title' => $user['name'],
            'subtitle' => 'User details.',
            'user' => $user,
            'error' => $request->query('error'),
            'success' => $request->query('success'),
        ], 'dashboard');
    }

    public function edit(Request $request, string $id): void
    {
        $this->requireAuth();

        $user = $this->users->find((int) $id);

        if (!$user) {
            $this->abort(404);
        }

        $user['role'] = $user['role_name'] ?? 'Employee';

        $this->view('dashboard/users/edit', [
            'title' => 'Edit User',
            'subtitle' => 'Update user details.',
            'user' => $user,
            'roles' => $this->users->roles(),
            'error' => $request->query('error'),
        ], 'dashboard');
    }

    public function update(Request $request, string $id): void
    {
        $this->requireAuth();
        $input = $request->all();
        $userId = (int) $id;

        $result = $this->users->update($userId, $input);

        if (!$result['ok']) {
            if ($result['error'] === 'User not found.') {
                $this->abort(404);
            }

            $this->view('dashboard/users/edit', [
                'title' => 'Edit User',
                'subtitle' => 'Update user details.',
                'user' => array_merge(['id' => $userId], $input),
                'roles' => $this->users->roles(),
                'error' => $result['error'],
            ], 'dashboard');
            return;
        }

        $this->redirect(
            '/dashboard/users/' . $userId .
            '?success=' . urlencode('User updated successfully.')
        );
    }

    public function destroy(Request $request, string $id): void
    {
        $authUser = $this->requireAuth();
        $userId = (int) $id;

        if ($userId === (int) ($authUser['id'] ?? 0)) {
            $this->redirect('/dashboard/users?error=' . urlencode('You cannot delete your own account.'));
        }

        if (!$this->users->delete($userId)) {
            $this->redirect('/dashboard/users?error=' . urlencode('User not found.'));
        }

        $this->redirect('/dashboard/users?success=' . urlencode('User deleted.'));
    }

    private function requireAuth(): array
    {
        if (!$this->auth->check()) {
            $this->redirect('/login');
        }

        return $this->auth->user();
    }

    private function emptyUser(): array
    {
        return [
            'name' => '',
            'email' => '',
            'role' => 'Employee',
            'password' => '',
            'password_confirmation' => '',
        ];
    }
}
