<?php

namespace App\Controllers;

use App\Core\BaseController;
use App\Core\PaginatesRequests;
use App\Core\Request;
use App\Core\Response;
use App\Services\AuthService;
use App\Services\MediaService;

class MediaController extends BaseController
{
    use PaginatesRequests;

    private MediaService $media;
    private AuthService $auth;

    public function __construct()
    {
        $this->media = new MediaService();
        $this->auth = new AuthService();
    }

    public function index(Request $request): void
    {
        $this->requireAuth();

        $paginator = $this->media->paginate($this->paginationOptions(
            $request,
            '/dashboard/media',
            10
        ));

        $this->view('dashboard/media/index', [
            'title' => 'Files',
            'subtitle' => 'Upload and manage project media.',
            'media' => $paginator->items,
            'paginator' => $paginator,
            'error' => $request->query('error'),
            'success' => $request->query('success'),
        ], 'dashboard');
    }

    public function store(Request $request): void
    {
        $user = $this->requireAuth();
        $file = $request->file('file');

        if (!$file) {
            $this->redirect('/dashboard/media?error=' . urlencode('No file was uploaded.'));
        }

        $result = $this->media->upload($file, (int) $user['id'], [
            'alt_text' => $request->body('alt_text'),
            'caption' => $request->body('caption'),
            'description' => $request->body('description'),
        ]);

        if (!$result['ok']) {
            $this->redirect('/dashboard/media?error=' . urlencode($result['error']));
        }

        $taskId = (int) $request->body('task_id', 0);

        if ($taskId > 0) {
            $this->media->attach($taskId, (int) $result['media']['id']);
            $this->redirect('/dashboard/media?success=' . urlencode('File uploaded and attached to task.'));
        }

        $this->redirect('/dashboard/media?success=' . urlencode('File uploaded successfully.'));
    }

    public function download(Request $request, string $id): void
    {
        $this->requireAuth();

        $record = $this->media->find((int) $id);

        if (!$record) {
            $this->abort(404);
        }

        $path = file_absolute_path($record['file_path']);

        if (!is_file($path)) {
            $this->abort(404);
        }

        header('Content-Type: ' . $record['mime_type']);
        header('Content-Length: ' . (string) filesize($path));
        header(
            'Content-Disposition: attachment; filename="' .
            str_replace('"', '', $record['original_name']) . '"'
        );
        header('X-Content-Type-Options: nosniff');

        readfile($path);
        exit;
    }

    public function destroy(Request $request, string $id): void
    {
        $this->requireAuth();

        if (!$this->media->delete((int) $id)) {
            $this->redirect('/dashboard/media?error=' . urlencode('Media not found.'));
        }

        $this->redirect('/dashboard/media?success=' . urlencode('File deleted.'));
    }

    public function attachToTask(Request $request, string $taskId): void
    {
        $user = $this->requireAuth();
        $taskId = (int) $taskId;
        $file = $request->file('file');

        if ($file) {
            $result = $this->media->uploadForTask($file, $taskId, (int) $user['id']);

            if (!$result['ok']) {
                Response::json(['ok' => false, 'error' => $result['error']], 422);
            }

            Response::json(['ok' => true, 'media' => $result['media']], 201);
        }

        $mediaId = (int) $request->body('media_id', 0);

        if ($mediaId <= 0) {
            Response::json(['ok' => false, 'error' => 'media_id or file is required.'], 422);
        }

        if (!$this->media->attach($taskId, $mediaId)) {
            Response::json(['ok' => false, 'error' => 'Media not found.'], 404);
        }

        Response::json(['ok' => true], 200);
    }

    public function detachFromTask(Request $request, string $taskId, string $mediaId): void
    {
        $this->requireAuth();

        if (!$this->media->detach((int) $taskId, (int) $mediaId)) {
            Response::json(['ok' => false, 'error' => 'Attachment not found.'], 404);
        }

        Response::json(['ok' => true], 200);
    }

    public function forTask(Request $request, string $taskId): void
    {
        $this->requireAuth();

        Response::json([
            'ok' => true,
            'media' => $this->media->forTask((int) $taskId),
        ]);
    }

    private function requireAuth(): array
    {
        if (!$this->auth->check()) {
            $this->redirect('/login');
        }

        return $this->auth->user();
    }
}
