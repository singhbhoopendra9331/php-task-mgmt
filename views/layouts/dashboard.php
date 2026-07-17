<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Dashboard') ?> | Task Management</title>
    <link rel="stylesheet" href="/assets/css/app.css">
</head>
<body class="min-h-screen bg-slate-100 font-sans text-slate-900">
    <div class="grid min-h-screen lg:grid-cols-[220px_1fr]">
        <aside class="flex flex-col gap-6 bg-sidebar p-4 text-slate-100">
            <div class="px-2 text-lg font-bold tracking-wide">Task Mgmt</div>
            <?php require ABS_PATH . '/views/partials/navbar.php'; ?>
            <form class="mt-auto" action="/logout" method="post">
                <button type="submit" class="btn-ghost">Logout</button>
            </form>
        </aside>

        <div class="flex min-w-0 flex-col">
            <header class="border-b border-slate-200 bg-white px-6 py-4">
                <h1 class="text-lg font-semibold"><?= htmlspecialchars($title ?? 'Dashboard') ?></h1>
            </header>

            <main class="mx-auto w-full max-w-5xl flex-1 px-4 py-6 sm:px-6">
                <?= $content ?>
            </main>

            <?php require ABS_PATH . '/views/partials/footer.php'; ?>
        </div>
    </div>

    <script src="/assets/js/jquery.min.js"></script>
    <script src="/assets/js/app.js"></script>
</body>
</html>
