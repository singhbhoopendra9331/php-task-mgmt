<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Login') ?> | Task Management</title>
    <link rel="stylesheet" href="/assets/css/app.css">
    <link rel="stylesheet" href="/assets/css/auth.css">
</head>
<body class="layout-auth">
    <main class="auth-shell">
        <div class="auth-card">
            <div class="auth-brand">Task Mgmt</div>
            <h1 class="auth-title"><?= htmlspecialchars($title ?? 'Login') ?></h1>
            <?= $content ?>
        </div>
    </main>
</body>
</html>
