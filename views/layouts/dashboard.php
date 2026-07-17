<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Dashboard') ?> | Task Management</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/app.css">
</head>
<body class="min-h-screen bg-surface font-sans text-slate-900 antialiased">
    <?php
    $authUser = (new \App\Services\AuthService())->user() ?? [];
    $path = rtrim(parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/', '/') ?: '/';
    ?>
    <div class="flex min-h-screen">
        <?php require ABS_PATH . '/views/partials/sidebar.php'; ?>

        <div class="flex min-w-0 flex-1 flex-col">
            <?php require ABS_PATH . '/views/partials/topbar.php'; ?>

            <main class="flex-1 overflow-auto p-4 sm:p-6">
                <?= $content ?>
            </main>
        </div>
    </div>

    <script src="/assets/js/jquery.min.js"></script>
    <script src="/assets/js/app.js"></script>
</body>
</html>
