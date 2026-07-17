<?php

namespace App\Services;

use App\Core\Session;
use App\Models\User;

class AuthService
{
    public function login(string $email, string $password): bool
    {
        $user = (new User())->findByEmail($email);

        if (!$user) {
            return false;
        }

        if (!password_verify($password, $user['password'])) {
            return false;
        }

        $this->setSessionUser($user);

        return true;
    }

    /**
     * @return array{ok: true}|array{ok: false, error: string}
     */
    public function register(
        string $name,
        string $email,
        string $password,
        string $passwordConfirmation
    ): array {
        $name = trim($name);
        $email = strtolower(trim($email));

        if ($name === '' || strlen($name) > 100) {
            return ['ok' => false, 'error' => 'Please enter a valid name.'];
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return ['ok' => false, 'error' => 'Please enter a valid email address.'];
        }

        if (strlen($password) < 8) {
            return ['ok' => false, 'error' => 'Password must be at least 8 characters.'];
        }

        if ($password !== $passwordConfirmation) {
            return ['ok' => false, 'error' => 'Passwords do not match.'];
        }

        $users = new User();

        if ($users->findByEmail($email)) {
            return ['ok' => false, 'error' => 'An account with this email already exists.'];
        }

        $roleId = $users->findRoleIdByName('Employee');

        if (!$roleId) {
            return ['ok' => false, 'error' => 'Default role is not configured.'];
        }

        $id = $users->create([
            'role_id' => $roleId,
            'name' => $name,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT),
        ]);

        $user = $users->find($id);

        if (!$user) {
            return ['ok' => false, 'error' => 'Registration failed. Please try again.'];
        }

        $this->setSessionUser($user);

        return ['ok' => true];
    }

    public function logout(): void
    {
        Session::destroy();
    }

    public function check(): bool
    {
        return Session::has('user');
    }

    public function user(): ?array
    {
        return Session::get('user');
    }

    private function setSessionUser(array $user): void
    {
        Session::put('user', [
            'id' => $user['id'],
            'name' => $user['name'],
            'email' => $user['email'],
        ]);
    }
}
