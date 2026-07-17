<?php

namespace App\Core;

trait PaginatesRequests
{
    protected function paginationOptions(
        Request $request,
        string $path,
        int $perPage = 15,
        array $extraQuery = []
    ): array {
        $query = array_merge($_GET, $extraQuery);
        unset($query['page']);

        // Drop flash-style params from pagination links
        unset($query['error'], $query['success'], $query['name'], $query['email']);

        return [
            'page' => max(1, (int) $request->query('page', 1)),
            'per_page' => max(1, (int) $request->query('per_page', $perPage)),
            'path' => $path,
            'query' => $query,
        ];
    }
}
