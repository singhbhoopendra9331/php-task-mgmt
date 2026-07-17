<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'PHP Task Management') ?></title>
    <link rel="stylesheet" href="/assets/css/app.css">
</head>
<body class="min-h-screen bg-slate-100 font-sans text-slate-900">
    <main class="mx-auto max-w-5xl px-4 py-8">
        <?= $content ?>
    </main>

    <script src="/assets/js/jquery.min.js"></script>
    <script src="/assets/js/app.js"></script>
</body>
</html>
