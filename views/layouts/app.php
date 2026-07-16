<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'PHP Task Management' ?></title>

    <link rel="stylesheet" href="/assets/css/app.css">
</head>
<body>

<?php require ABS_PATH . '/views/partials/navbar.php'; ?>

<main class="container">
    <?= $content ?>
</main>

<?php require ABS_PATH . '/views/partials/footer.php'; ?>

</body>
</html>