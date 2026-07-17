<?php

namespace App\Models;

use App\Core\Model;

class Media extends Model
{
    protected string $table = 'media';

    public function create(array $data): int
    {
        $this->db->query(
            "INSERT INTO media (
                uploaded_by, original_name, file_name, file_path,
                mime_type, extension, file_size, alt_text, caption, description
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)",
            [
                $data['uploaded_by'],
                $data['original_name'],
                $data['file_name'],
                $data['file_path'],
                $data['mime_type'],
                $data['extension'],
                $data['file_size'],
                $data['alt_text'] ?? null,
                $data['caption'] ?? null,
                $data['description'] ?? null,
            ]
        );

        return (int) $this->db->lastInsertId();
    }

    public function forTask(int $taskId): array
    {
        return $this->db
            ->query(
                "SELECT m.*
                 FROM media m
                 INNER JOIN task_media tm ON tm.media_id = m.id
                 WHERE tm.task_id = ?
                 ORDER BY tm.created_at DESC",
                [$taskId]
            )
            ->fetchAll();
    }

    public function attachToTask(int $taskId, int $mediaId): bool
    {
        try {
            $this->db->query(
                "INSERT INTO task_media (task_id, media_id) VALUES (?, ?)",
                [$taskId, $mediaId]
            );

            return true;
        } catch (\PDOException $e) {
            // Duplicate attachment
            if ((int) $e->errorInfo[1] === 1062) {
                return false;
            }

            throw $e;
        }
    }

    public function detachFromTask(int $taskId, int $mediaId): bool
    {
        return $this->db
            ->query(
                "DELETE FROM task_media WHERE task_id = ? AND media_id = ?",
                [$taskId, $mediaId]
            )
            ->rowCount() > 0;
    }

    public function isAttachedToTask(int $taskId, int $mediaId): bool
    {
        $row = $this->db
            ->query(
                "SELECT id FROM task_media WHERE task_id = ? AND media_id = ? LIMIT 1",
                [$taskId, $mediaId]
            )
            ->fetch();

        return (bool) $row;
    }

    public function taskIds(int $mediaId): array
    {
        $rows = $this->db
            ->query(
                "SELECT task_id FROM task_media WHERE media_id = ?",
                [$mediaId]
            )
            ->fetchAll();

        return array_column($rows, 'task_id');
    }
}
