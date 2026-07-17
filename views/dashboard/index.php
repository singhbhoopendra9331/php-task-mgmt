<?php
/** @var array $tasks */
?>

<section class="space-y-6">
    <p class="text-slate-500">Overview of your tasks and media.</p>

    <div class="flex flex-wrap gap-4">
        <a class="font-semibold text-brand hover:underline" href="/dashboard/tasks">View tasks</a>
        <a class="font-semibold text-brand hover:underline" href="/dashboard/media">Media library</a>
    </div>

    <div>
        <h2 class="mb-3 text-lg font-semibold">Recent tasks</h2>

        <?php if (empty($tasks)): ?>
            <p class="text-slate-500">No tasks yet.</p>
        <?php else: ?>
            <ul class="list-disc space-y-1 pl-5">
                <?php foreach ($tasks as $task): ?>
                    <li><?= htmlspecialchars($task['title'] ?? ('Task #' . ($task['id'] ?? ''))) ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
</section>
