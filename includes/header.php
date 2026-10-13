<?php
require_once __DIR__ . '/helpers.php';
require_once __DIR__ . '/../config/database.php';
$flash = pull_flash();
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= e($pageTitle ?? 'Inventaris') ?></title>
  <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<header class="topbar"><a href="index.php">Inventaris</a></header>
<main class="container">
<?php if ($flash): ?>
  <div class="alert <?= e($flash['type']) ?>" role="alert"><?= e($flash['message']) ?></div>
<?php endif; ?>
