<form id="login-form" class="grid gap-4" action="/login" method="POST">
    <div class="grid gap-1.5">
        <label class="label" for="email">Email</label>
        <input
            class="input"
            id="email"
            type="email"
            name="email"
            placeholder="you@example.com"
            required
            autofocus
        >
    </div>

    <div class="grid gap-1.5">
        <label class="label" for="password">Password</label>
        <input
            class="input"
            id="password"
            type="password"
            name="password"
            placeholder="Password"
            required
        >
    </div>

    <button class="btn w-full" type="submit">Sign in</button>
</form>
