<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<!DOCTYPE html>
<html lang="sl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Odbojkarska liga</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <h1>Odbojkarska liga</h1>
    <nav>
        <a href="index.php">Domov</a>
        <a href="player_list.php">Igralci</a>

        <?php if (isset($_SESSION['username'])): ?>
            <span>Pozdravljen, <?php echo htmlspecialchars($_SESSION['username']); ?></span>
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                <a href="admin.php">Admin</a>
            <?php endif; ?>
            <a href="logout.php">Odjava</a>
        <?php else: ?>
            <a href="login.php">Prijava</a>
            <a href="register.php">Registracija</a>
        <?php endif; ?>
    </nav>
</header>

<main>