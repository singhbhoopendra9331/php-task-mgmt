<?php
/** @var string $path */
$isDashboard = $path === '/dashboard';
$isTasks = str_starts_with($path, '/dashboard/tasks');
$isMedia = str_starts_with($path, '/dashboard/media');
$isProjectsModule = str_starts_with($path, '/dashboard/projects');
$sidebarProjects = (new \App\Services\ProjectService())->recent(5);
?>

<aside class="sticky top-0 flex h-screen w-[260px] shrink-0 flex-col border-r border-slate-200 bg-white">
    <div class="flex items-center gap-3 border-b border-slate-200 px-5 py-4">
        <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-brand text-white shadow-sm">
            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                <path d="M12 3l7 3v5c0 4.5-2.8 7.8-7 10-4.2-2.2-7-5.5-7-10V6l7-3z" stroke="currentColor"
                    stroke-width="1.8" />
                <path d="M9.5 12.2l1.8 1.8 3.7-3.8" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"
                    stroke-linejoin="round" />
            </svg>
        </div>
        <div>
            <div class="text-sm font-bold text-slate-900">Task Mgmt</div>
            <div class="text-xs text-slate-500">Project workspace</div>
        </div>
    </div>

    <nav class="flex-1 space-y-1 overflow-y-auto px-3 py-4">
        <a class="nav-link js-nav-link <?= $isDashboard && !$isTasks ? 'is-active' : '' ?>" href="/dashboard">
            <svg class="h-4 w-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                <path d="M4 10.5L12 4l8 6.5V20a1 1 0 0 1-1 1h-5v-6H10v6H5a1 1 0 0 1-1-1v-9.5z" />
            </svg>
            Dashboard
        </a>

        <div>
            <a class="nav-link js-nav-link <?= $isProjectsModule ? 'is-active' : '' ?>" href="/dashboard/projects">
                <svg class="h-4 w-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <rect x="3" y="4" width="7" height="7" rx="1.5" />
                    <rect x="14" y="4" width="7" height="7" rx="1.5" />
                    <rect x="3" y="13" width="7" height="7" rx="1.5" />
                    <rect x="14" y="13" width="7" height="7" rx="1.5" />
                </svg>
                Projects
            </a>
            <div class="mt-1 space-y-1">
                <a class="nav-sublink js-nav-link <?= $isTasks ? 'is-active' : '' ?>" href="/dashboard/tasks">Tasks</a>
                <a class="nav-sublink js-nav-link <?= $isDashboard && !$isTasks && !$isProjectsModule ? 'is-active' : '' ?>"
                    href="/dashboard/timeline">Timeline</a>
                <a class="nav-sublink text-slate-400" href="/dashboard/calendar">Calendar</a>
            </div>
        </div>

        <a class="nav-link" href="#">
            <svg class="h-4 w-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                <circle cx="9" cy="8" r="3.5" />
                <circle cx="16.5" cy="9.5" r="2.5" />
                <path d="M3.5 19a5.5 5.5 0 0 1 11 0" />
                <path d="M14 19a4 4 0 0 1 6.5-3.1" />
            </svg>
            Team
        </a>
        <a class="nav-link" href="#">
            <svg class="h-4 w-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                <path d="M4 19V5" />
                <path d="M4 19h16" />
                <path d="M8 15v-4" />
                <path d="M12 15V8" />
                <path d="M16 15v-6" />
            </svg>
            Reports
        </a>
        <a class="nav-link js-nav-link <?= $isMedia ? 'is-active' : '' ?>" href="/dashboard/media">
            <svg class="h-4 w-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                <path
                    d="M4 7.5A2.5 2.5 0 0 1 6.5 5H9l1.2-1.5A1 1 0 0 1 11 3h2a1 1 0 0 1 .8.4L15 5h2.5A2.5 2.5 0 0 1 20 7.5v9A2.5 2.5 0 0 1 17.5 19h-11A2.5 2.5 0 0 1 4 16.5v-9z" />
                <circle cx="12" cy="12" r="3.2" />
            </svg>
            Files
        </a>
        <a class="nav-link" href="#">
            <svg class="h-4 w-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                <path d="M21 15a2 2 0 0 1-2 2H8l-4 3V5a2 2 0 0 1 2-2h13a2 2 0 0 1 2 2z" />
            </svg>
            Messages
        </a>
        <a class="nav-link" href="#">
            <svg class="h-4 w-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                <circle cx="12" cy="12" r="3" />
                <path
                    d="M19.4 15a1.7 1.7 0 0 0 .3 1.8l.1.1a2 2 0 1 1-2.8 2.8l-.1-.1a1.7 1.7 0 0 0-1.8-.3 1.7 1.7 0 0 0-1 1.5V21a2 2 0 1 1-4 0v-.1a1.7 1.7 0 0 0-1-1.5 1.7 1.7 0 0 0-1.8.3l-.1.1a2 2 0 1 1-2.8-2.8l.1-.1a1.7 1.7 0 0 0 .3-1.8 1.7 1.7 0 0 0-1.5-1H3a2 2 0 1 1 0-4h.1a1.7 1.7 0 0 0 1.5-1 1.7 1.7 0 0 0-.3-1.8l-.1-.1a2 2 0 1 1 2.8-2.8l.1.1a1.7 1.7 0 0 0 1.8.3H9a1.7 1.7 0 0 0 1-1.5V3a2 2 0 1 1 4 0v.1a1.7 1.7 0 0 0 1 1.5 1.7 1.7 0 0 0 1.8-.3l.1-.1a2 2 0 1 1 2.8 2.8l-.1.1a1.7 1.7 0 0 0-.3 1.8V9c.2.6.8 1 1.5 1H21a2 2 0 1 1 0 4h-.1a1.7 1.7 0 0 0-1.5 1z" />
            </svg>
            Settings
        </a>
    </nav>

    <div class="border-t border-slate-200 px-4 py-4">
        <div class="mb-3 flex items-center justify-between">
            <span class="text-xs font-semibold tracking-wide text-slate-400 uppercase">Projects</span>
            <a href="/dashboard/projects/create"
                class="flex h-6 w-6 items-center justify-center rounded-md text-slate-400 hover:bg-slate-100 hover:text-slate-700"
                aria-label="Add project">+</a>
        </div>
        <ul class="space-y-2 text-sm">
            <?php if (empty($sidebarProjects)): ?>
                <li class="px-2 text-slate-400">No projects yet</li>
            <?php else: ?>
                <?php foreach ($sidebarProjects as $sidebarProject): ?>
                    <li>
                        <a href="/dashboard/projects/<?= (int) $sidebarProject['id'] ?>/edit"
                           class="flex items-center gap-2 rounded-lg px-2 py-1.5 <?= ($path === '/dashboard/projects/' . (int) $sidebarProject['id'] . '/edit') ? 'bg-brand-soft font-medium text-brand' : 'text-slate-800 hover:bg-slate-100' ?>">
                            <span class="h-2.5 w-2.5 shrink-0 rounded-full bg-brand"></span>
                            <span class="truncate"><?= htmlspecialchars($sidebarProject['name']) ?></span>
                        </a>
                    </li>
                <?php endforeach; ?>
            <?php endif; ?>
        </ul>

        <form class="mt-4" action="/logout" method="post">
            <button type="submit" class="btn-ghost w-full justify-start px-2">Logout</button>
        </form>
    </div>
</aside>