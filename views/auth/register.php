<form id="register-form" class="grid gap-4" action="/register" method="POST">
    <?php if (!empty($error)): ?>
        <p class="alert-error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <div class="grid gap-1.5">
        <label class="label" for="name">Name</label>
        <input
            class="input"
            id="name"
            type="text"
            name="name"
            placeholder="Your name"
            value="<?= htmlspecialchars($old['name'] ?? '') ?>"
            required
            autofocus
            maxlength="100"
        >
    </div>

    <div class="grid gap-1.5">
        <label class="label" for="email">Email</label>
        <input
            class="input"
            id="email"
            type="email"
            name="email"
            placeholder="you@example.com"
            value="<?= htmlspecialchars($old['email'] ?? '') ?>"
            required
        >
    </div>

    <div class="grid gap-1.5">
        <label class="label" for="password">Password</label>
        <input
            class="input"
            id="password"
            type="password"
            name="password"
            placeholder="At least 8 characters"
            required
            minlength="8"
        >
    </div>

    <div class="grid gap-1.5">
        <label class="label" for="password_confirmation">Confirm password</label>
        <input
            class="input"
            id="password_confirmation"
            type="password"
            name="password_confirmation"
            placeholder="Repeat password"
            required
            minlength="8"
        >
    </div>

    <button class="btn w-full" type="submit">Create account</button>

    <p class="text-center text-sm text-slate-500">
        Already have an account?
        <a class="font-semibold text-brand hover:underline" href="/login">Sign in</a>
    </p>
</form>
