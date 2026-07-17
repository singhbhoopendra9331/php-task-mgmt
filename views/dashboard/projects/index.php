<?php
/** @var array $projects */
/** @var string|null $error */
/** @var string|null $success */

$statusLabels = [
    'planning' => 'Planning',
    'active' => 'Active',
    'completed' => 'Completed',
    'archived' => 'Archived',
];
?>

<section class="space-y-6">
    <div class="flex flex-wrap items-center justify-between gap-3">
        <p class="text-slate-500">Organize work by project. Create, update, or archive projects here.</p>
        <a href="/dashboard/projects/create" class="btn whitespace-nowrap">
            <span class="text-base leading-none">+</span>
            New Project
        </a>
    </div>

    <?php if (!empty($error)): ?>
        <p class="alert-error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <?php if (!empty($success)): ?>
        <p class="alert-success"><?= htmlspecialchars($success) ?></p>
    <?php endif; ?>

    <div>
        <?php if (empty($projects)): ?>
            <div class="card">
                <p class="text-slate-500">No projects yet. Create your first project to get started.</p>
            </div>
        <?php else: ?>
            <div class="overflow-x-auto">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Status</th>
                            <th>Owner</th>
                            <th>Start</th>
                            <th>End</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($projects as $project): ?>
                            <tr>
                                <td>
                                    <div class="font-medium text-slate-900"><?= htmlspecialchars($project['name']) ?></div>
                                    <?php if (!empty($project['description'])): ?>
                                        <div class="mt-1 text-slate-500"><?= htmlspecialchars(mb_strimwidth($project['description'], 0, 80, '…')) ?></div>
                                    <?php endif; ?>
                                </td>
                                <td><?= htmlspecialchars($statusLabels[$project['status']] ?? $project['status']) ?></td>
                                <td><?= htmlspecialchars($project['owner_name'] ?? '—') ?></td>
                                <td><?= htmlspecialchars($project['start_date'] ?? '—') ?></td>
                                <td><?= htmlspecialchars($project['end_date'] ?? '—') ?></td>
                                <td>
                                    <div class="flex items-center gap-3">
                                        <a class="font-medium text-brand hover:underline" href="/dashboard/projects/<?= (int) $project['id'] ?>/edit">Edit</a>
                                        <form action="/dashboard/projects/<?= (int) $project['id'] ?>/delete" method="post" data-confirm="Delete this project? Related tasks may be affected.">
                                            <button type="submit" class="font-medium text-red-600 hover:underline">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                <?php pagination($paginator ?? null); ?>
            </div>
        <?php endif; ?>
    </div>
</section>
