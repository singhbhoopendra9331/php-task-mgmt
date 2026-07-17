<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Dashboard') ?> | Task Management</title>
    <link rel="stylesheet" href="/assets/css/app.css">
    <link rel="stylesheet" href="/assets/css/dashboard.css">
</head>
<body class="layout-dashboard">
    <div class="dashboard-shell">
        <aside class="dashboard-sidebar">
            <div class="sidebar-brand">Task Mgmt</div>
            <?php require ABS_PATH . '/views/partials/navbar.php'; ?>
            <form class="sidebar-logout" action="/logout" method="post">
                <button type="submit">Logout</button>
            </form>
        </aside>

        <div class="dashboard-main">
            <header class="dashboard-topbar">
                <h1 class="topbar-title"><?= htmlspecialchars($title ?? 'Dashboard') ?></h1>
            </header>

            <main class="dashboard-content">
                <?= $content ?>
            </main>

            <?php require ABS_PATH . '/views/partials/footer.php'; ?>
        </div>
    </div>
</body>
</html>
