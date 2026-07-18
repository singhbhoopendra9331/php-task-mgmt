<?php

namespace App\Services;

use App\Core\Paginator;
use App\Models\User;

class UserService
{
    private User $users;

    public function __construct(?User $users = null)
    {
        $this->users = $users ?? new User();
    }

    /**
     * @return array{ok: true, user: array}|array{ok: false, error: string}
     */
    public function create(array $input): array
    {
        $validated = $this->validate($input, null);

        if (!$validated['ok']) {
            return $validated;
        }

        $id = $this->users->create($validated['data']);
        $user = $this->users->findWithRole($id);

        if (!$user) {
            return ['ok' => false, 'error' => 'Failed to save user.'];
        }

        return ['ok' => true, 'user' => $user];
    }

    /**
     * @return array{ok: true, user: array}|array{ok: false, error: string}
     */
    public function update(int $id, array $input): array
    {
        $user = $this->users->find($id);

        if (!$user) {
            return ['ok' => false, 'error' => 'User not found.'];
        }

        $validated = $this->validate($input, $id);

        if (!$validated['ok']) {
            return $validated;
        }

        $this->users->update($id, $validated['data']);

        $updated = $this->users->findWithRole($id);

        if (!$updated) {
            return ['ok' => false, 'error' => 'Failed to update user.'];
        }

        return ['ok' => true, 'user' => $updated];
    }

    public function delete(int $id): bool
    {
        if (!$this->users->find($id)) {
            return false;
        }

        return $this->users->delete($id);
    }

    public function find(int $id): array|false
    {
        return $this->users->findWithRole($id);
    }

    public function roles(): array
    {
        return $this->users->roles();
    }

    public function paginate(array $options = []): Paginator
    {
        return $this->users->paginateWithRole(array_merge([
            'order_by' => 'created_at',
            'direction' => 'DESC',
            'per_page' => 10,
        ], $options));
    }

    /**
     * @return array{ok: true, data: array}|array{ok: false, error: string}
     */
    private function validate(array $input, ?int $ignoreUserId): array
    {
        $name = trim((string) ($input['name'] ?? ''));
        $email = strtolower(trim((string) ($input['email'] ?? '')));
        $role = trim((string) ($input['role'] ?? 'Employee'));
        $password = (string) ($input['password'] ?? '');
        $passwordConfirmation = (string) ($input['password_confirmation'] ?? '');
        $isCreate = $ignoreUserId === null;

        if ($name === '' || strlen($name) > 100) {
            return ['ok' => false, 'error' => 'Please enter a valid name (max 100 characters).'];
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 255) {
            return ['ok' => false, 'error' => 'Please enter a valid email address.'];
        }

        if (!in_array($role, User::ROLES, true)) {
            return ['ok' => false, 'error' => 'Please select a valid role.'];
        }

        $existing = $this->users->findByEmail($email);

        if ($existing && (int) $existing['id'] !== (int) $ignoreUserId) {
            return ['ok' => false, 'error' => 'An account with this email already exists.'];
        }

        if ($isCreate || $password !== '') {
            if (strlen($password) < 8) {
                return ['ok' => false, 'error' => 'Password must be at least 8 characters.'];
            }

            if ($password !== $passwordConfirmation) {
                return ['ok' => false, 'error' => 'Passwords do not match.'];
            }
        }

        $roleId = $this->users->findRoleIdByName($role);

        if (!$roleId) {
            return ['ok' => false, 'error' => 'Selected role is not configured.'];
        }

        $data = [
            'role_id' => $roleId,
            'name' => $name,
            'email' => $email,
        ];

        if ($isCreate || $password !== '') {
            $data['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        return ['ok' => true, 'data' => $data];
    }
}
