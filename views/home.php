<h1>Dashboard</h1>

<ul>
    <?php foreach ($tasks as $task): ?>
        <li><?= htmlspecialchars($task['title']) ?></li>
    <?php endforeach; ?>
</ul>