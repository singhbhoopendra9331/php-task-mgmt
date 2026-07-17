<?php

namespace App\Models;

use App\Core\Model;

class User extends Model
{
    protected string $table = 'users';

    protected int $perPage = 15;

    public function findByEmail(string $email): array|false
    {
        return $this->db
            ->query(
                "SELECT * FROM users WHERE email = ? LIMIT 1",
                [$email]
            )
            ->fetch();
    }

    public function findRoleIdByName(string $name): int|false
    {
        $role = $this->db
            ->query(
                "SELECT id FROM roles WHERE name = ? LIMIT 1",
                [$name]
            )
            ->fetch();

        return $role ? (int) $role['id'] : false;
    }

    public function create(array $data): int
    {
        $this->db->query(
            "INSERT INTO users (role_id, name, email, password) VALUES (?, ?, ?, ?)",
            [
                $data['role_id'],
                $data['name'],
                $data['email'],
                $data['password'],
            ]
        );

        return (int) $this->db->lastInsertId();
    }
}
