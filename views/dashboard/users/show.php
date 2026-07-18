<?php
/** @var array $user */
/** @var string|null $error */
/** @var string|null $success */

$userId = (int) $user['id'];
?>

<section class="space-y-6">
    <?php if (!empty($error)): ?>
        <p class="alert-error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <?php if (!empty($success)): ?>
        <p class="alert-success"><?= htmlspecialchars($success) ?></p>
    <?php endif; ?>

    <div class="flex flex-wrap items-center justify-between gap-3">
        <a class="btn-ghost px-0" href="/dashboard/users">&larr; All users</a>
        <div class="flex flex-wrap items-center gap-2">
            <a class="btn-secondary" href="/dashboard/users/<?= $userId ?>/edit">Edit</a>
            <form action="/dashboard/users/<?= $userId ?>/delete" method="post"
                  data-confirm="Delete this user? Related records may be removed.">
                <button type="submit" class="btn-secondary text-red-600">Delete</button>
            </form>
        </div>
    </div>

    <div class="card space-y-4">
        <div class="flex flex-wrap items-start justify-between gap-3">
            <div class="min-w-0 space-y-1">
                <h2 class="text-xl font-semibold text-slate-900"><?= htmlspecialchars($user['name']) ?></h2>
                <p class="text-slate-500"><?= htmlspecialchars($user['email']) ?></p>
            </div>
            <span class="rounded-lg bg-brand-soft px-3 py-1.5 text-sm font-medium text-brand">
                <?= htmlspecialchars($user['role_name'] ?? '—') ?>
            </span>
        </div>

        <div class="grid gap-4 grid-cols-2">
            <div>
                <div class="text-xs font-semibold tracking-wide text-slate-400 uppercase">Role</div>
                <div class="mt-1 text-sm text-slate-900"><?= htmlspecialchars($user['role_name'] ?? '—') ?></div>
                <?php if (!empty($user['role_description'])): ?>
                    <div class="text-sm text-slate-500"><?= htmlspecialchars($user['role_description']) ?></div>
                <?php endif; ?>
            </div>
            <div>
                <div class="text-xs font-semibold tracking-wide text-slate-400 uppercase">Email verified</div>
                <div class="mt-1 text-sm text-slate-900">
                    <?= !empty($user['email_verified_at']) ? htmlspecialchars($user['email_verified_at']) : 'Not verified' ?>
                </div>
            </div>
            <div>
                <div class="text-xs font-semibold tracking-wide text-slate-400 uppercase">Created</div>
                <div class="mt-1 text-sm text-slate-900"><?= htmlspecialchars($user['created_at'] ?? '—') ?></div>
            </div>
            <div>
                <div class="text-xs font-semibold tracking-wide text-slate-400 uppercase">Updated</div>
                <div class="mt-1 text-sm text-slate-900"><?= htmlspecialchars($user['updated_at'] ?? '—') ?></div>
            </div>
        </div>
    </div>
</section>
