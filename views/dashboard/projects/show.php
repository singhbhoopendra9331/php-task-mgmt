<?php
/** @var array $project */
/** @var array $members */
/** @var array $tasks */
/** @var string|null $error */
/** @var string|null $success */

$statusLabels = [
    'planning' => 'Planning',
    'active' => 'Active',
    'completed' => 'Completed',
    'archived' => 'Archived',
];

$roleLabels = [
    'owner' => 'Owner',
    'manager' => 'Manager',
    'member' => 'Member',
];

$taskStatusLabels = [
    'todo' => 'To do',
    'in_progress' => 'In progress',
    'review' => 'Review',
    'completed' => 'Completed',
];

$projectId = (int) $project['id'];
?>

<section class="space-y-6">
    <?php if (!empty($error)): ?>
        <p class="alert-error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <?php if (!empty($success)): ?>
        <p class="alert-success"><?= htmlspecialchars($success) ?></p>
    <?php endif; ?>

    <div class="flex flex-wrap items-center justify-between gap-3">
        <a class="btn-ghost px-0" href="/dashboard/projects">&larr; All projects</a>
        <div class="flex flex-wrap items-center gap-2">
            <a class="btn-secondary" href="/dashboard/projects/<?= $projectId ?>/edit">Edit</a>
            <form action="/dashboard/projects/<?= $projectId ?>/delete" method="post"
                  data-confirm="Delete this project? Related tasks may be affected.">
                <button type="submit" class="btn-secondary text-red-600">Delete</button>
            </form>
        </div>
    </div>

    <div class="card space-y-4">
        <div class="flex flex-wrap items-start justify-between gap-3">
            <div class="min-w-0 space-y-1">
                <h2 class="text-xl font-semibold text-slate-900"><?= htmlspecialchars($project['name']) ?></h2>
                <?php if (!empty($project['description'])): ?>
                    <p class="text-slate-500"><?= nl2br(htmlspecialchars($project['description'])) ?></p>
                <?php else: ?>
                    <p class="text-slate-400">No description provided.</p>
                <?php endif; ?>
            </div>
            <span class="rounded-lg bg-brand-soft px-3 py-1.5 text-sm font-medium text-brand">
                <?= htmlspecialchars($statusLabels[$project['status']] ?? $project['status']) ?>
            </span>
        </div>

        <div class="grid gap-4 grid-cols-2">
            <div>
                <div class="text-xs font-semibold tracking-wide text-slate-400 uppercase">Owner</div>
                <div class="mt-1 text-sm text-slate-900"><?= htmlspecialchars($project['owner_name'] ?? '—') ?></div>
                <?php if (!empty($project['owner_email'])): ?>
                    <div class="text-sm text-slate-500"><?= htmlspecialchars($project['owner_email']) ?></div>
                <?php endif; ?>
            </div>
            <div>
                <div class="text-xs font-semibold tracking-wide text-slate-400 uppercase">Dates</div>
                <div class="mt-1 text-sm text-slate-900">
                    <?= htmlspecialchars($project['start_date'] ?? '—') ?>
                    &rarr;
                    <?= htmlspecialchars($project['end_date'] ?? '—') ?>
                </div>
            </div>
            <div>
                <div class="text-xs font-semibold tracking-wide text-slate-400 uppercase">Created</div>
                <div class="mt-1 text-sm text-slate-900"><?= htmlspecialchars($project['created_at'] ?? '—') ?></div>
            </div>
            <div>
                <div class="text-xs font-semibold tracking-wide text-slate-400 uppercase">Updated</div>
                <div class="mt-1 text-sm text-slate-900"><?= htmlspecialchars($project['updated_at'] ?? '—') ?></div>
            </div>
        </div>
    </div>

    <div class="card space-y-4">
        <h3 class="text-lg font-semibold text-slate-900">Members</h3>

        <?php if (empty($members)): ?>
            <p class="text-slate-500">No members on this project yet.</p>
        <?php else: ?>
            <div class="overflow-x-auto">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Joined</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($members as $member): ?>
                            <tr>
                                <td><?= htmlspecialchars($member['name']) ?></td>
                                <td><?= htmlspecialchars($member['email']) ?></td>
                                <td><?= htmlspecialchars($roleLabels[$member['role']] ?? $member['role']) ?></td>
                                <td><?= htmlspecialchars($member['joined_at'] ?? '—') ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>

    <div class="card space-y-4">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <h3 class="text-lg font-semibold text-slate-900">Tasks</h3>
            <a class="btn-secondary" href="/dashboard/tasks">View all tasks</a>
        </div>

        <?php if (empty($tasks)): ?>
            <p class="text-slate-500">No tasks in this project yet.</p>
        <?php else: ?>
            <div class="overflow-x-auto">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Priority</th>
                            <th>Status</th>
                            <th>Assignee</th>
                            <th>Due</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($tasks as $task): ?>
                            <tr>
                                <td><?= htmlspecialchars($task['title'] ?? '') ?></td>
                                <td><?= htmlspecialchars(ucfirst($task['priority'] ?? '')) ?></td>
                                <td><?= htmlspecialchars($taskStatusLabels[$task['status']] ?? $task['status'] ?? '') ?></td>
                                <td><?= htmlspecialchars($task['assignee_name'] ?? '—') ?></td>
                                <td><?= htmlspecialchars($task['due_date'] ?? '—') ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</section>
