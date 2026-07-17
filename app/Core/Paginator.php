<?php

namespace App\Core;

class Paginator
{
    public function __construct(
        public readonly array $items,
        public readonly int $total,
        public readonly int $perPage,
        public readonly int $currentPage,
        public readonly string $path = '/',
        public readonly array $query = [],
        public readonly string $pageName = 'page'
    ) {
    }

    public function lastPage(): int
    {
        return max(1, (int) ceil($this->total / max(1, $this->perPage)));
    }

    public function from(): ?int
    {
        if ($this->total === 0) {
            return null;
        }

        return (($this->currentPage - 1) * $this->perPage) + 1;
    }

    public function to(): ?int
    {
        if ($this->total === 0) {
            return null;
        }

        return min($this->total, $this->currentPage * $this->perPage);
    }

    public function hasPages(): bool
    {
        return $this->lastPage() > 1;
    }

    public function hasMorePages(): bool
    {
        return $this->currentPage < $this->lastPage();
    }

    public function onFirstPage(): bool
    {
        return $this->currentPage <= 1;
    }

    public function previousPageUrl(): ?string
    {
        if ($this->onFirstPage()) {
            return null;
        }

        return $this->url($this->currentPage - 1);
    }

    public function nextPageUrl(): ?string
    {
        if (!$this->hasMorePages()) {
            return null;
        }

        return $this->url($this->currentPage + 1);
    }

    public function url(int $page): string
    {
        $page = max(1, min($page, $this->lastPage()));
        $query = $this->query;
        $query[$this->pageName] = $page;

        $qs = http_build_query($query);

        return $this->path . ($qs !== '' ? '?' . $qs : '');
    }

    /**
     * @return list<array{type: string, page?: int, url?: string, label: string}>
     */
    public function elements(): array
    {
        $last = $this->lastPage();
        $current = $this->currentPage;
        $window = 2;

        $pages = [];

        for ($i = 1; $i <= $last; $i++) {
            if (
                $i === 1
                || $i === $last
                || ($i >= $current - $window && $i <= $current + $window)
            ) {
                $pages[] = $i;
            }
        }

        $elements = [];
        $previous = null;

        foreach ($pages as $page) {
            if ($previous !== null && $page - $previous > 1) {
                $elements[] = [
                    'type' => 'ellipsis',
                    'label' => '…',
                ];
            }

            $elements[] = [
                'type' => 'page',
                'page' => $page,
                'url' => $this->url($page),
                'label' => (string) $page,
            ];

            $previous = $page;
        }

        return $elements;
    }

    public function toArray(): array
    {
        return [
            'data' => $this->items,
            'total' => $this->total,
            'per_page' => $this->perPage,
            'current_page' => $this->currentPage,
            'last_page' => $this->lastPage(),
            'from' => $this->from(),
            'to' => $this->to(),
            'path' => $this->path,
            'first_page_url' => $this->url(1),
            'last_page_url' => $this->url($this->lastPage()),
            'prev_page_url' => $this->previousPageUrl(),
            'next_page_url' => $this->nextPageUrl(),
        ];
    }
}
