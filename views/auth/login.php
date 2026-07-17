<form class="auth-form" action="/login" method="POST">
    <div class="field">
        <label for="email">Email</label>
        <input
            id="email"
            type="email"
            name="email"
            placeholder="you@example.com"
            required
            autofocus
        >
    </div>

    <div class="field">
        <label for="password">Password</label>
        <input
            id="password"
            type="password"
            name="password"
            placeholder="Password"
            required
        >
    </div>

    <button type="submit">Sign in</button>
</form>
