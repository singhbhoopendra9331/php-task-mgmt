<?php
/** @var array $project */
/** @var array $statuses */
/** @var string|null $error */
/** @var string $action */
/** @var string $submitLabel */

$action = $action ?? '/dashboard/projects';
$submitLabel = $submitLabel ?? 'Create Project';
$statusLabels = [
    'planning' => 'Planning',
    'active' => 'Active',
    'completed' => 'Completed',
    'archived' => 'Archived',
];
?>

<section class="space-y-6">
    <?php if (!empty($error)): ?>
        <p class="alert-error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form class="card grid max-w-5xl gap-4" action="<?= htmlspecialchars($action) ?>" method="post">
        <div class="grid gap-1.5">
            <label class="label" for="name">Name</label>
            <input class="input" type="text" id="name" name="name" required maxlength="150"
                   value="<?= htmlspecialchars($project['name'] ?? '') ?>"
                   placeholder="e.g. BrandSecure AI">
        </div>

        <div class="grid gap-1.5">
            <label class="label" for="description">Description (optional)</label>
            <textarea class="input" id="description" name="description" rows="4"
                      placeholder="What is this project about?"><?= htmlspecialchars($project['description'] ?? '') ?></textarea>
        </div>

        <div class="grid gap-1.5">
            <label class="label" for="status">Status</label>
            <select class="input" id="status" name="status">
                <?php foreach ($statuses as $status): ?>
                    <option value="<?= htmlspecialchars($status) ?>"
                        <?= ($project['status'] ?? '') === $status ? 'selected' : '' ?>>
                        <?= htmlspecialchars($statusLabels[$status] ?? $status) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="grid gap-4 grid-cols-2">
            <div class="grid gap-1.5">
                <label class="label" for="start_date">Start date (optional)</label>
                <input class="input" type="date" id="start_date" name="start_date"
                       value="<?= htmlspecialchars($project['start_date'] ?? '') ?>">
            </div>

            <div class="grid gap-1.5">
                <label class="label" for="end_date">End date (optional)</label>
                <input class="input" type="date" id="end_date" name="end_date"
                       value="<?= htmlspecialchars($project['end_date'] ?? '') ?>">
            </div>
        </div>

        <div class="flex flex-wrap items-center gap-3">
            <button class="btn" type="submit"><?= htmlspecialchars($submitLabel) ?></button>
            <a class="btn-secondary" href="/dashboard/projects">Cancel</a>
        </div>
    </form>
</section>
