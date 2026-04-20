<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-commerce MVC</title>
    <link rel="stylesheet" href="/css/common.css">
    <link rel="stylesheet" href="/css/product.css">
    <link rel="stylesheet" href="/css/cart.css">
    <link rel="stylesheet" href="/css/admin.css">
    <link rel="stylesheet" href="/css/auth.css">
</head>
<body>
<header class="main-header">
    <a href="<?php echo (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin') ? '/admin/dashboard' : '/'; ?>" class="logo">ShopMVC</a>
    <nav class="nav-links">
        <?php if(!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin'): ?>
            <a href="/">Home</a>
            <a href="/cart">Cart (<?php echo isset($_SESSION['cart']) ? array_sum($_SESSION['cart']) : 0; ?>)</a>
        <?php endif; ?>

        <?php if(isset($_SESSION['user_id'])): ?>
            <?php if($_SESSION['user_role'] === 'admin'): ?>
                <a href="/admin/dashboard">Admin Dashboard</a>
            <?php endif; ?>
            <a href="/logout">Logout</a>
        <?php else: ?>
            <a href="/login">Login</a>
            <a href="/register">Register</a>
        <?php endif; ?>
    </nav>
</header>
<main>
