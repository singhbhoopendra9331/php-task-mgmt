<?php
/** @var array $tasks */
?>

<section class="card space-y-4">
    <p class="text-slate-500">Manage project tasks.</p>

    <?php if (empty($tasks)): ?>
        <p class="text-slate-500">No tasks found.</p>
    <?php else: ?>
        <div class="overflow-x-auto">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Priority</th>
                        <th>Status</th>
                        <th>Due</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($tasks as $task): ?>
                        <tr>
                            <td><?= htmlspecialchars($task['title'] ?? '') ?></td>
                            <td><?= htmlspecialchars($task['priority'] ?? '') ?></td>
                            <td><?= htmlspecialchars($task['status'] ?? '') ?></td>
                            <td><?= htmlspecialchars($task['due_date'] ?? '—') ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</section>
