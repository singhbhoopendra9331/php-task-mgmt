<?php

namespace App\Services;

use App\Core\Paginator;
use App\Models\Project;

class ProjectService
{
    private Project $projects;

    public function __construct(?Project $projects = null)
    {
        $this->projects = $projects ?? new Project();
    }

    /**
     * @return array{ok: true, project: array}|array{ok: false, error: string}
     */
    public function create(array $input, int $ownerId): array
    {
        $validated = $this->validate($input);

        if (!$validated['ok']) {
            return $validated;
        }

        $id = $this->projects->create([
            ...$validated['data'],
            'owner_id' => $ownerId,
        ]);

        $this->projects->addMember($id, $ownerId, 'owner');

        $project = $this->projects->find($id);

        if (!$project) {
            return ['ok' => false, 'error' => 'Failed to save project.'];
        }

        return ['ok' => true, 'project' => $project];
    }

    /**
     * @return array{ok: true, project: array}|array{ok: false, error: string}
     */
    public function update(int $id, array $input): array
    {
        $project = $this->projects->find($id);

        if (!$project) {
            return ['ok' => false, 'error' => 'Project not found.'];
        }

        $validated = $this->validate($input);

        if (!$validated['ok']) {
            return $validated;
        }

        $this->projects->update($id, $validated['data']);

        $updated = $this->projects->find($id);

        if (!$updated) {
            return ['ok' => false, 'error' => 'Failed to update project.'];
        }

        return ['ok' => true, 'project' => $updated];
    }

    public function delete(int $id): bool
    {
        if (!$this->projects->find($id)) {
            return false;
        }

        return $this->projects->delete($id);
    }

    public function find(int $id): array|false
    {
        return $this->projects->find($id);
    }

    public function findWithDetails(int $id): array|false
    {
        $project = $this->projects->findWithOwner($id);

        if (!$project) {
            return false;
        }

        return [
            'project' => $project,
            'members' => $this->projects->members($id),
            'tasks' => $this->projects->tasks($id),
        ];
    }

    public function paginate(array $options = []): Paginator
    {
        return $this->projects->paginateWithOwner(array_merge([
            'order_by' => 'created_at',
            'direction' => 'DESC',
            'per_page' => 10,
        ], $options));
    }

    public function recent(int $limit = 5): array
    {
        return $this->projects->recent($limit);
    }

    /**
     * @return array{ok: true, data: array}|array{ok: false, error: string}
     */
    private function validate(array $input): array
    {
        $name = trim((string) ($input['name'] ?? ''));
        $description = trim((string) ($input['description'] ?? ''));
        $status = (string) ($input['status'] ?? 'planning');
        $startDate = trim((string) ($input['start_date'] ?? ''));
        $endDate = trim((string) ($input['end_date'] ?? ''));

        if ($name === '' || strlen($name) > 150) {
            return ['ok' => false, 'error' => 'Please enter a project name (max 150 characters).'];
        }

        if (!in_array($status, Project::STATUSES, true)) {
            return ['ok' => false, 'error' => 'Please select a valid status.'];
        }

        if ($startDate !== '' && !$this->isValidDate($startDate)) {
            return ['ok' => false, 'error' => 'Please enter a valid start date.'];
        }

        if ($endDate !== '' && !$this->isValidDate($endDate)) {
            return ['ok' => false, 'error' => 'Please enter a valid end date.'];
        }

        if ($startDate !== '' && $endDate !== '' && $endDate < $startDate) {
            return ['ok' => false, 'error' => 'End date must be on or after the start date.'];
        }

        return [
            'ok' => true,
            'data' => [
                'name' => $name,
                'description' => $description !== '' ? $description : null,
                'status' => $status,
                'start_date' => $startDate !== '' ? $startDate : null,
                'end_date' => $endDate !== '' ? $endDate : null,
            ],
        ];
    }

    private function isValidDate(string $date): bool
    {
        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
            return false;
        }

        [$year, $month, $day] = array_map('intval', explode('-', $date));

        return checkdate($month, $day, $year);
    }
}
