<?php

namespace App\Core;

abstract class Model
{
    protected Database $db;

    protected string $table;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function all(): array
    {
        return $this->db
            ->query("SELECT * FROM {$this->table}")
            ->fetchAll();
    }

    public function find(int $id): array|false
    {
        return $this->db
            ->query(
                "SELECT * FROM {$this->table} WHERE id = ?",
                [$id]
            )
            ->fetch();
    }

    public function delete(int $id): bool
    {
        return $this->db
            ->query(
                "DELETE FROM {$this->table} WHERE id = ?",
                [$id]
            )
            ->rowCount() > 0;
    }
}