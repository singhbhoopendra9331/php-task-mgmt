<?php
/** @var array $user */
/** @var array $roles */
/** @var string|null $error */
/** @var string $action */
/** @var string $submitLabel */

$action = $action ?? '/dashboard/users';
$submitLabel = $submitLabel ?? 'Create User';
$cancelUrl = $cancelUrl ?? '/dashboard/users';
$isEdit = isset($user['id']);
$selectedRole = $user['role'] ?? $user['role_name'] ?? 'Employee';
?>

<section class="space-y-6">
    <?php if (!empty($error)): ?>
        <p class="alert-error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form class="card grid max-w-5xl gap-4" action="<?= htmlspecialchars($action) ?>" method="post">
        <div class="grid gap-1.5">
            <label class="label" for="name">Name</label>
            <input class="input" type="text" id="name" name="name" required maxlength="100"
                   value="<?= htmlspecialchars($user['name'] ?? '') ?>"
                   placeholder="e.g. Jane Doe">
        </div>

        <div class="grid gap-1.5">
            <label class="label" for="email">Email</label>
            <input class="input" type="email" id="email" name="email" required maxlength="255"
                   value="<?= htmlspecialchars($user['email'] ?? '') ?>"
                   placeholder="jane@example.com">
        </div>

        <div class="grid gap-1.5">
            <label class="label" for="role">Role</label>
            <select class="input" id="role" name="role" required>
                <?php foreach ($roles as $role): ?>
                    <option value="<?= htmlspecialchars($role['name']) ?>"
                        <?= $selectedRole === $role['name'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($role['name']) ?>
                        <?php if (!empty($role['description'])): ?>
                            — <?= htmlspecialchars($role['description']) ?>
                        <?php endif; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="grid gap-4 grid-cols-2">
            <div class="grid gap-1.5">
                <label class="label" for="password">
                    Password<?= $isEdit ? ' (optional)' : '' ?>
                </label>
                <input class="input" type="password" id="password" name="password"
                       <?= $isEdit ? '' : 'required' ?> minlength="8"
                       placeholder="<?= $isEdit ? 'Leave blank to keep current' : 'At least 8 characters' ?>">
            </div>

            <div class="grid gap-1.5">
                <label class="label" for="password_confirmation">Confirm password</label>
                <input class="input" type="password" id="password_confirmation" name="password_confirmation"
                       <?= $isEdit ? '' : 'required' ?> minlength="8"
                       placeholder="Repeat password">
            </div>
        </div>

        <div class="flex flex-wrap items-center gap-3">
            <button class="btn" type="submit"><?= htmlspecialchars($submitLabel) ?></button>
            <a class="btn-secondary" href="<?= htmlspecialchars($cancelUrl) ?>">Cancel</a>
        </div>
    </form>
</section>
