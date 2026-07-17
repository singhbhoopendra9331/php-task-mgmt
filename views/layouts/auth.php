<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Login') ?> | Task Management</title>
    <link rel="stylesheet" href="/assets/css/app.css">
</head>
<body class="min-h-screen bg-gradient-to-br from-slate-100 via-blue-50 to-slate-200 font-sans text-slate-900">
    <?php
    $path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
    $isRegister = str_starts_with(rtrim((string) $path, '/') ?: '/', '/register');
    ?>
    <main class="grid min-h-screen place-items-center p-6">
        <div class="w-full max-w-sm rounded-xl border border-slate-200 bg-white p-8 shadow-lg">
            <div class="mb-2 font-bold text-brand">Task Mgmt</div>
            <h1 class="mb-4 text-2xl font-semibold"><?= htmlspecialchars($title ?? 'Login') ?></h1>

            <div class="mb-6 grid grid-cols-2 gap-2 rounded-lg bg-slate-100 p-1">
                <a
                    href="/login"
                    class="rounded-md px-3 py-2 text-center text-sm font-semibold <?= $isRegister ? 'text-slate-500 hover:text-slate-800' : 'bg-white text-slate-900 shadow-sm' ?>"
                >
                    Login
                </a>
                <a
                    href="/register"
                    class="rounded-md px-3 py-2 text-center text-sm font-semibold <?= $isRegister ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-500 hover:text-slate-800' ?>"
                >
                    Register
                </a>
            </div>

            <?= $content ?>
        </div>
    </main>

    <script src="/assets/js/jquery.min.js"></script>
    <script src="/assets/js/app.js"></script>
</body>
</html>
