<?php

namespace App\Models;

use App\Core\Model;
use App\Core\Paginator;

class User extends Model
{
    protected string $table = 'users';

    protected int $perPage = 15;

    public const ROLES = ['Admin', 'Manager', 'Employee'];

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

    public function roles(): array
    {
        return $this->db
            ->query(
                "SELECT id, name, description
                 FROM roles
                 ORDER BY FIELD(name, 'Admin', 'Manager', 'Employee'), name ASC"
            )
            ->fetchAll();
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

    public function update(int $id, array $data): bool
    {
        if (isset($data['password'])) {
            $this->db->query(
                "UPDATE users SET
                    role_id = ?,
                    name = ?,
                    email = ?,
                    password = ?
                 WHERE id = ?",
                [
                    $data['role_id'],
                    $data['name'],
                    $data['email'],
                    $data['password'],
                    $id,
                ]
            );
        } else {
            $this->db->query(
                "UPDATE users SET
                    role_id = ?,
                    name = ?,
                    email = ?
                 WHERE id = ?",
                [
                    $data['role_id'],
                    $data['name'],
                    $data['email'],
                    $id,
                ]
            );
        }

        return true;
    }

    public function findWithRole(int $id): array|false
    {
        return $this->db
            ->query(
                "SELECT u.id, u.role_id, u.name, u.email, u.email_verified_at,
                        u.created_at, u.updated_at,
                        r.name AS role_name, r.description AS role_description
                 FROM users u
                 LEFT JOIN roles r ON r.id = u.role_id
                 WHERE u.id = ?
                 LIMIT 1",
                [$id]
            )
            ->fetch();
    }

    public function paginateWithRole(array $options = []): Paginator
    {
        $orderBy = $this->sanitizeColumn($options['order_by'] ?? 'created_at');
        $direction = $this->sanitizeDirection($options['direction'] ?? 'DESC');

        if (in_array($orderBy, ['id', 'name', 'email', 'created_at', 'updated_at'], true)) {
            $orderBy = 'u.' . $orderBy;
        }

        return $this->paginateQuery(
            "SELECT u.id, u.role_id, u.name, u.email, u.email_verified_at,
                    u.created_at, u.updated_at,
                    r.name AS role_name
             FROM users u
             LEFT JOIN roles r ON r.id = u.role_id
             ORDER BY {$orderBy} {$direction}",
            'SELECT COUNT(*) AS aggregate FROM users',
            [],
            $options
        );
    }
}
