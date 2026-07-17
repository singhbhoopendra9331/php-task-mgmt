<?php
/** @var array $tasks */
?>

<section class="dashboard-page">
    <p class="muted">Overview of your tasks and media.</p>

    <div class="dashboard-links">
        <a href="/dashboard/tasks">View tasks</a>
        <a href="/dashboard/media">Media library</a>
    </div>

    <h2>Recent tasks</h2>

    <?php if (empty($tasks)): ?>
        <p class="muted">No tasks yet.</p>
    <?php else: ?>
        <ul>
            <?php foreach ($tasks as $task): ?>
                <li><?= htmlspecialchars($task['title'] ?? ('Task #' . ($task['id'] ?? ''))) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</section>
