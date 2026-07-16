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

        Session::put('user', [
            'id' => $user['id'],
            'name' => $user['name'],
            'email' => $user['email'],
        ]);

        return true;
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
}