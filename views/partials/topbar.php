<?php
/** @var array $authUser */
/** @var string $path */
$name = $authUser['name'] ?? 'User';
$initials = strtoupper(substr($name, 0, 1));
$pageTitle = $title ?? 'Dashboard';
$pageSubtitle = $subtitle ?? 'Track progress across tasks and team.';
$isProjectsPage = str_starts_with($path ?? '', '/dashboard/projects');
$isUsersPage = str_starts_with($path ?? '', '/dashboard/users');
?>

<header class="sticky top-0 z-20 border-b border-slate-200 bg-white/95 backdrop-blur">
    <div class="flex items-center justify-between gap-4 px-4 py-3 sm:px-6">
        <div class="min-w-0">
            <h1 class="truncate text-xl font-semibold text-slate-900"><?= htmlspecialchars($pageTitle) ?></h1>
            <p class="truncate text-sm text-slate-500"><?= htmlspecialchars($pageSubtitle) ?></p>
        </div>

        <div class="flex items-center gap-2 sm:gap-3">
            <button type="button" class="icon-btn" aria-label="Search">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="11" cy="11" r="7"/><path d="M20 20l-3.5-3.5"/></svg>
            </button>

            <button type="button" class="icon-btn" aria-label="Notifications">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M6 9a6 6 0 1 1 12 0c0 7 3 7 3 7H3s3 0 3-7"/><path d="M10 19a2 2 0 0 0 4 0"/></svg>
                <span class="absolute top-1.5 right-1.5 flex h-4 min-w-4 items-center justify-center rounded-full bg-rose-500 px-1 text-[10px] font-bold text-white">3</span>
            </button>

            <div class="hidden items-center gap-3 rounded-full border border-slate-200 py-1 pr-3 pl-1 sm:flex">
                <div class="flex h-8 w-8 items-center justify-center rounded-full bg-brand text-xs font-bold text-white">
                    <?= htmlspecialchars($initials) ?>
                </div>
                <div class="leading-tight">
                    <div class="text-sm font-semibold text-slate-900"><?= htmlspecialchars($name) ?></div>
                    <div class="text-xs text-slate-500">Project Manager</div>
                </div>
            </div>

            <?php if ($isUsersPage): ?>
                <a href="/dashboard/users/create" class="btn whitespace-nowrap">
                    <span class="text-base leading-none">+</span>
                    Add User
                </a>
            <?php elseif ($isProjectsPage): ?>
                <a href="/dashboard/projects/create" class="btn whitespace-nowrap">
                    <span class="text-base leading-none">+</span>
                    Add Project
                </a>
            <?php else: ?>
                <a href="/dashboard/tasks" class="btn whitespace-nowrap">
                    <span class="text-base leading-none">+</span>
                    Add Task
                </a>
            <?php endif; ?>
        </div>
    </div>
</header>
