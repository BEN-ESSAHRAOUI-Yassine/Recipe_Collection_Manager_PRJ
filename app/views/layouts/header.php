<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recipe Collection Manager</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/style.css">
</head>
<body>

<header>
    <h1>Recipe Collection Manager</h1>
    <nav>
        <?php if (isset($_SESSION['user'])): ?>
            <a href="<?= BASE_URL ?>?url=favorite/index">Favorites</a>
            <a href="<?= BASE_URL ?>?url=category/index">Category Dashboard</a>
            <a href="<?= BASE_URL ?>?url=recipe/index">Recipe Dashboard</a>
            
            <?php if ($_SESSION['user']['role'] === 'admin'): ?>
                <a href="<?= BASE_URL ?>?url=admin/users">User Dashboard</a>
            <?php endif; ?>

            <a href="<?= BASE_URL ?>?url=logout">Logout</a>
        <?php endif; ?>
    </nav>
</header>

<div class="container">

<?php
// Show flash message if there is one (success, error, info)
$flash = Security::getFlash();
if ($flash): ?>
    <div class="alert alert-<?= htmlspecialchars($flash['type']) ?>">
        <?= htmlspecialchars($flash['message']) ?>
    </div>
<?php endif; ?>