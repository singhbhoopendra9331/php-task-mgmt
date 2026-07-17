<?php
/** @var \App\Core\Paginator|null $paginator */
if (empty($paginator) || !$paginator instanceof \App\Core\Paginator || !$paginator->hasPages()) {
    return;
}
?>

<nav class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between" aria-label="Pagination">
    <p class="text-sm text-slate-500">
        Showing
        <span class="font-medium text-slate-800"><?= (int) $paginator->from() ?></span>
        to
        <span class="font-medium text-slate-800"><?= (int) $paginator->to() ?></span>
        of
        <span class="font-medium text-slate-800"><?= (int) $paginator->total ?></span>
        results
    </p>

    <div class="flex flex-wrap items-center gap-1">
        <?php if ($paginator->previousPageUrl()): ?>
            <a class="btn-secondary px-3 py-1.5" href="<?= htmlspecialchars($paginator->previousPageUrl()) ?>">Previous</a>
        <?php else: ?>
            <span class="btn-secondary cursor-not-allowed px-3 py-1.5 opacity-50">Previous</span>
        <?php endif; ?>

        <?php foreach ($paginator->elements() as $element): ?>
            <?php if ($element['type'] === 'ellipsis'): ?>
                <span class="px-2 text-sm text-slate-400"><?= htmlspecialchars($element['label']) ?></span>
            <?php elseif ((int) $element['page'] === $paginator->currentPage): ?>
                <span class="inline-flex min-w-9 items-center justify-center rounded-lg bg-brand px-3 py-1.5 text-sm font-semibold text-white">
                    <?= htmlspecialchars($element['label']) ?>
                </span>
            <?php else: ?>
                <a class="btn-secondary min-w-9 px-3 py-1.5" href="<?= htmlspecialchars($element['url']) ?>">
                    <?= htmlspecialchars($element['label']) ?>
                </a>
            <?php endif; ?>
        <?php endforeach; ?>

        <?php if ($paginator->nextPageUrl()): ?>
            <a class="btn-secondary px-3 py-1.5" href="<?= htmlspecialchars($paginator->nextPageUrl()) ?>">Next</a>
        <?php else: ?>
            <span class="btn-secondary cursor-not-allowed px-3 py-1.5 opacity-50">Next</span>
        <?php endif; ?>
    </div>
</nav>
