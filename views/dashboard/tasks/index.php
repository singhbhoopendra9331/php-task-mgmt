<?php
/** @var array $tasks */
?>

<section class="tasks-page">
    <p class="muted">Manage project tasks.</p>

    <?php if (empty($tasks)): ?>
        <p class="muted">No tasks found.</p>
    <?php else: ?>
        <table class="media-table">
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
    <?php endif; ?>
</section>
