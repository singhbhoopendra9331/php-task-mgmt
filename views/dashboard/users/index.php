<?php
/** @var array $users */
/** @var string|null $error */
/** @var string|null $success */
?>

<section class="space-y-6">
    <div class="flex flex-wrap items-center justify-between gap-3">
        <p class="text-slate-500">Manage team members and their roles.</p>
        <a href="/dashboard/users/create" class="btn whitespace-nowrap">
            <span class="text-base leading-none">+</span>
            New User
        </a>
    </div>

    <?php if (!empty($error)): ?>
        <p class="alert-error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <?php if (!empty($success)): ?>
        <p class="alert-success"><?= htmlspecialchars($success) ?></p>
    <?php endif; ?>

    <div>
        <?php if (empty($users)): ?>
            <div class="card">
                <p class="text-slate-500">No users yet. Create your first team member to get started.</p>
            </div>
        <?php else: ?>
            <div class="overflow-x-auto">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Joined</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td>
                                    <a class="font-medium text-brand hover:underline" href="/dashboard/users/<?= (int) $user['id'] ?>">
                                        <?= htmlspecialchars($user['name'] ?? '') ?>
                                    </a>
                                </td>
                                <td><?= htmlspecialchars($user['email'] ?? '') ?></td>
                                <td><?= htmlspecialchars($user['role_name'] ?? '—') ?></td>
                                <td><?= htmlspecialchars($user['created_at'] ?? '—') ?></td>
                                <td>
                                    <div class="flex items-center gap-3">
                                        <a class="font-medium text-brand hover:underline" href="/dashboard/users/<?= (int) $user['id'] ?>">View</a>
                                        <a class="font-medium text-brand hover:underline" href="/dashboard/users/<?= (int) $user['id'] ?>/edit">Edit</a>
                                        <form action="/dashboard/users/<?= (int) $user['id'] ?>/delete" method="post" data-confirm="Delete this user? Related records may be removed.">
                                            <button type="submit" class="font-medium text-red-600 hover:underline">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                <?php pagination($paginator ?? null); ?>
            </div>
        <?php endif; ?>
    </div>
</section>
