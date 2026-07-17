<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Login') ?> | Task Management</title>
    <link rel="stylesheet" href="/assets/css/app.css">
</head>
<body class="min-h-screen bg-gradient-to-br from-slate-100 via-blue-50 to-slate-200 font-sans text-slate-900">
    <main class="grid min-h-screen place-items-center p-6">
        <div class="w-full max-w-sm rounded-xl border border-slate-200 bg-white p-8 shadow-lg">
            <div class="mb-2 font-bold text-brand">Task Mgmt</div>
            <h1 class="mb-6 text-2xl font-semibold"><?= htmlspecialchars($title ?? 'Login') ?></h1>
            <?= $content ?>
        </div>
    </main>

    <script src="/assets/js/jquery.min.js"></script>
    <script src="/assets/js/app.js"></script>
</body>
</html>
