<?php

use App\Support\Auth;

$appName = config('app.name', 'Vault & Shipping Suite');
$pageTitle = $pageTitle ?? $appName;
$currentUser = Auth::user();

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle) ?> | <?= htmlspecialchars($appName) ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= asset('css/styles.css') ?>">
</head>
<body>
<header class="site-header">
    <div class="container header-inner">
        <a class="brand" href="<?= base_url('index.php') ?>"><?= htmlspecialchars($appName) ?></a>
        <nav class="main-nav">
            <a href="<?= base_url('index.php') ?>">Home</a>
            <?php if ($currentUser && $currentUser['role'] === 'admin'): ?>
                <a href="<?= base_url('admin/index.php') ?>">Admin</a>
            <?php endif; ?>
            <?php if ($currentUser): ?>
                <a href="<?= base_url('dashboard.php') ?>">My Vault</a>
                <a class="btn btn-secondary" href="<?= base_url('logout.php') ?>">Logout</a>
            <?php else: ?>
                <a href="<?= base_url('tracking.php') ?>">Track Shipment</a>
                <a class="btn btn-primary" href="<?= base_url('login.php') ?>">Login</a>
            <?php endif; ?>
        </nav>
    </div>
</header>
<main class="site-main">
