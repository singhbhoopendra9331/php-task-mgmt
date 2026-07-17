<?php

namespace App\Services;

use App\Models\Media;

class MediaService
{
    private Media $media;

    public function __construct(?Media $media = null)
    {
        $this->media = $media ?? new Media();
    }

    /**
     * Validate, store on disk, and persist a media record.
     *
     * @return array{ok: true, media: array}|array{ok: false, error: string}
     */
    public function upload(array $file, int $uploadedBy, array $meta = []): array
    {
        $stored = file_store($file);

        if (!$stored['ok']) {
            return $stored;
        }

        $id = $this->media->create([
            'uploaded_by' => $uploadedBy,
            'original_name' => $stored['original_name'],
            'file_name' => $stored['file_name'],
            'file_path' => $stored['file_path'],
            'mime_type' => $stored['mime_type'],
            'extension' => $stored['extension'],
            'file_size' => $stored['file_size'],
            'alt_text' => $meta['alt_text'] ?? null,
            'caption' => $meta['caption'] ?? null,
            'description' => $meta['description'] ?? null,
        ]);

        $record = $this->media->find($id);

        if (!$record) {
            file_delete($stored['file_path']);

            return ['ok' => false, 'error' => 'Failed to save media record.'];
        }

        return ['ok' => true, 'media' => $record];
    }

    /**
     * Upload a file and attach it to a task.
     *
     * @return array{ok: true, media: array}|array{ok: false, error: string}
     */
    public function uploadForTask(array $file, int $taskId, int $uploadedBy, array $meta = []): array
    {
        $result = $this->upload($file, $uploadedBy, $meta);

        if (!$result['ok']) {
            return $result;
        }

        $this->media->attachToTask($taskId, (int) $result['media']['id']);

        return $result;
    }

    public function attach(int $taskId, int $mediaId): bool
    {
        if (!$this->media->find($mediaId)) {
            return false;
        }

        $this->media->attachToTask($taskId, $mediaId);

        return true;
    }

    public function detach(int $taskId, int $mediaId): bool
    {
        return $this->media->detachFromTask($taskId, $mediaId);
    }

    /**
     * Remove DB row, task links (via cascade), and disk file.
     */
    public function delete(int $mediaId): bool
    {
        $record = $this->media->find($mediaId);

        if (!$record) {
            return false;
        }

        $deleted = $this->media->delete($mediaId);

        if ($deleted) {
            file_delete($record['file_path']);
        }

        return $deleted;
    }

    public function all(): array
    {
        return $this->media->all('created_at', 'DESC');
    }

    public function paginate(array $options = []): \App\Core\Paginator
    {
        return $this->media->paginate(array_merge([
            'order_by' => 'created_at',
            'direction' => 'DESC',
            'per_page' => 10,
        ], $options));
    }

    public function find(int $id): array|false
    {
        return $this->media->find($id);
    }

    public function forTask(int $taskId): array
    {
        return $this->media->forTask($taskId);
    }
}
