<?php

namespace App\Core;

abstract class Model
{
    protected Database $db;

    protected string $table;

    protected string $primaryKey = 'id';

    protected int $perPage = 15;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function all(string $orderBy = null, string $direction = 'ASC'): array
    {
        $orderBy = $this->sanitizeColumn($orderBy ?? $this->primaryKey);
        $direction = $this->sanitizeDirection($direction);

        return $this->db
            ->query("SELECT * FROM {$this->table} ORDER BY {$orderBy} {$direction}")
            ->fetchAll();
    }

    public function find(int $id): array|false
    {
        return $this->db
            ->query(
                "SELECT * FROM {$this->table} WHERE {$this->primaryKey} = ?",
                [$id]
            )
            ->fetch();
    }

    public function delete(int $id): bool
    {
        return $this->db
            ->query(
                "DELETE FROM {$this->table} WHERE {$this->primaryKey} = ?",
                [$id]
            )
            ->rowCount() > 0;
    }

    public function count(string $where = '1=1', array $bindings = []): int
    {
        $row = $this->db
            ->query(
                "SELECT COUNT(*) AS aggregate FROM {$this->table} WHERE {$where}",
                $bindings
            )
            ->fetch();

        return (int) ($row['aggregate'] ?? 0);
    }

    /**
     * Paginate rows for this model table.
     *
     * @param array{
     *   page?: int,
     *   per_page?: int,
     *   order_by?: string,
     *   direction?: string,
     *   where?: string,
     *   bindings?: array,
     *   path?: string,
     *   query?: array,
     *   page_name?: string
     * } $options
     */
    public function paginate(array $options = []): Paginator
    {
        $pageName = $options['page_name'] ?? 'page';
        $perPage = max(1, (int) ($options['per_page'] ?? $this->perPage));
        $page = max(1, (int) ($options['page'] ?? 1));
        $orderBy = $this->sanitizeColumn($options['order_by'] ?? $this->primaryKey);
        $direction = $this->sanitizeDirection($options['direction'] ?? 'DESC');
        $where = $options['where'] ?? '1=1';
        $bindings = $options['bindings'] ?? [];
        $path = $options['path'] ?? '/';
        $query = $options['query'] ?? [];

        $total = $this->count($where, $bindings);
        $lastPage = max(1, (int) ceil($total / $perPage));
        $page = min($page, $lastPage);
        $offset = ($page - 1) * $perPage;

        $items = $this->db
            ->query(
                "SELECT * FROM {$this->table}
                 WHERE {$where}
                 ORDER BY {$orderBy} {$direction}
                 LIMIT {$perPage} OFFSET {$offset}",
                $bindings
            )
            ->fetchAll();

        return new Paginator(
            items: $items,
            total: $total,
            perPage: $perPage,
            currentPage: $page,
            path: $path,
            query: $query,
            pageName: $pageName
        );
    }

    /**
     * Paginate an arbitrary SELECT with a matching COUNT query.
     *
     * @param array{
     *   page?: int,
     *   per_page?: int,
     *   path?: string,
     *   query?: array,
     *   page_name?: string
     * } $options
     */
    public function paginateQuery(
        string $selectSql,
        string $countSql,
        array $bindings = [],
        array $options = []
    ): Paginator {
        $pageName = $options['page_name'] ?? 'page';
        $perPage = max(1, (int) ($options['per_page'] ?? $this->perPage));
        $page = max(1, (int) ($options['page'] ?? 1));
        $path = $options['path'] ?? '/';
        $query = $options['query'] ?? [];

        $countRow = $this->db->query($countSql, $bindings)->fetch();
        $total = (int) ($countRow['aggregate'] ?? $countRow['count'] ?? 0);
        $lastPage = max(1, (int) ceil($total / $perPage));
        $page = min($page, $lastPage);
        $offset = ($page - 1) * $perPage;

        $items = $this->db
            ->query(
                $selectSql . " LIMIT {$perPage} OFFSET {$offset}",
                $bindings
            )
            ->fetchAll();

        return new Paginator(
            items: $items,
            total: $total,
            perPage: $perPage,
            currentPage: $page,
            path: $path,
            query: $query,
            pageName: $pageName
        );
    }

    protected function sanitizeColumn(?string $column): string
    {
        $column = $column ?: $this->primaryKey;

        if (!preg_match('/^[A-Za-z0-9_\.]+$/', $column)) {
            return $this->primaryKey;
        }

        return $column;
    }

    protected function sanitizeDirection(string $direction): string
    {
        return strtoupper($direction) === 'ASC' ? 'ASC' : 'DESC';
    }
}
