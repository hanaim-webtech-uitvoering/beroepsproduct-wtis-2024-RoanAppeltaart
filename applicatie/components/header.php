<?php
// Sessie starten om loginstatus te kunnen tonen
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function maakHeader($titel)
{
    if (isset($_SESSION['user'])) {
        $loginStatus = htmlspecialchars($_SESSION['user']) .
                       ' | <a href="logout.php">Uitloggen</a>';
    } else {
        $loginStatus = '<a href="login.php">Inloggen</a>';
    }

    return <<<HTML
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>$titel</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<header class="site-header">
    <div class="header-top">
        <h1>Pizzeria Sole Machina</h1>

        <div class="login-status">
            $loginStatus
        </div>
    </div>

    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="menu.php">Menu</a></li>
            <li><a href="winkelmand.php">Winkelmand</a></li>
            <li><a href="bestellingen.php">Bestellingen</a></li>
            <li><a href="profiel.php">Profiel</a></li>
        </ul>
    </nav>
</header>

<main>
HTML;
}
