<?php

namespace App\Models;

use App\Core\Model;
use App\Core\Paginator;

class Project extends Model
{
    protected string $table = 'projects';

    protected int $perPage = 10;

    public const STATUSES = ['planning', 'active', 'completed', 'archived'];

    public function create(array $data): int
    {
        $this->db->query(
            "INSERT INTO projects (
                name, description, status, start_date, end_date, owner_id
            ) VALUES (?, ?, ?, ?, ?, ?)",
            [
                $data['name'],
                $data['description'] ?? null,
                $data['status'] ?? 'planning',
                $data['start_date'] ?? null,
                $data['end_date'] ?? null,
                $data['owner_id'],
            ]
        );

        return (int) $this->db->lastInsertId();
    }

    public function update(int $id, array $data): bool
    {
        $this->db->query(
            "UPDATE projects SET
                name = ?,
                description = ?,
                status = ?,
                start_date = ?,
                end_date = ?
             WHERE id = ?",
            [
                $data['name'],
                $data['description'] ?? null,
                $data['status'] ?? 'planning',
                $data['start_date'] ?? null,
                $data['end_date'] ?? null,
                $id,
            ]
        );

        return true;
    }

    public function addMember(int $projectId, int $userId, string $role = 'member'): bool
    {
        try {
            $this->db->query(
                "INSERT INTO project_members (project_id, user_id, role) VALUES (?, ?, ?)",
                [$projectId, $userId, $role]
            );

            return true;
        } catch (\PDOException $e) {
            if ((int) ($e->errorInfo[1] ?? 0) === 1062) {
                return false;
            }

            throw $e;
        }
    }

    public function paginateWithOwner(array $options = []): Paginator
    {
        $orderBy = $this->sanitizeColumn($options['order_by'] ?? 'created_at');
        $direction = $this->sanitizeDirection($options['direction'] ?? 'DESC');

        // Qualify id columns for the join.
        if ($orderBy === 'id' || $orderBy === 'created_at' || $orderBy === 'updated_at' || $orderBy === 'name' || $orderBy === 'status') {
            $orderBy = 'p.' . $orderBy;
        }

        return $this->paginateQuery(
            "SELECT p.*, u.name AS owner_name
             FROM projects p
             LEFT JOIN users u ON u.id = p.owner_id
             ORDER BY {$orderBy} {$direction}",
            'SELECT COUNT(*) AS aggregate FROM projects',
            [],
            $options
        );
    }

    public function findWithOwner(int $id): array|false
    {
        return $this->db
            ->query(
                "SELECT p.*, u.name AS owner_name, u.email AS owner_email
                 FROM projects p
                 LEFT JOIN users u ON u.id = p.owner_id
                 WHERE p.id = ?
                 LIMIT 1",
                [$id]
            )
            ->fetch();
    }

    public function members(int $projectId): array
    {
        return $this->db
            ->query(
                "SELECT pm.id, pm.role, pm.joined_at, u.id AS user_id, u.name, u.email
                 FROM project_members pm
                 INNER JOIN users u ON u.id = pm.user_id
                 WHERE pm.project_id = ?
                 ORDER BY
                    FIELD(pm.role, 'owner', 'manager', 'member'),
                    u.name ASC",
                [$projectId]
            )
            ->fetchAll();
    }

    public function tasks(int $projectId): array
    {
        return $this->db
            ->query(
                "SELECT t.*, u.name AS assignee_name
                 FROM tasks t
                 LEFT JOIN users u ON u.id = t.assigned_to
                 WHERE t.project_id = ?
                 ORDER BY t.created_at DESC",
                [$projectId]
            )
            ->fetchAll();
    }

    public function recent(int $limit = 5): array
    {
        $limit = max(1, min(20, $limit));

        return $this->db
            ->query(
                "SELECT id, name, status
                 FROM projects
                 ORDER BY updated_at DESC
                 LIMIT {$limit}"
            )
            ->fetchAll();
    }
}
