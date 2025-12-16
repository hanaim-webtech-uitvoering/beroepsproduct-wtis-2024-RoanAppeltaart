<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function maakHeader($titel)
{
    $isIngelogd = isset($_SESSION['user']);
    $rol = $isIngelogd && isset($_SESSION['role']) ? $_SESSION['role'] : '';

    if ($isIngelogd) {
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

    <nav class="main-nav">
        <ul class="nav-left">
            <li><a href="index.php">Home</a></li>
            <li><a href="menu.php">Menu</a></li>
HTML
.
($isIngelogd && $rol === 'Customer'
    ? '<li><a href="mijn_bestellingen.php">Mijn Bestellingen</a></li>'
    : ''
)
.
($isIngelogd && $rol === 'Personnel'
    ? '<li><a href="bestellingen.php">Bestellingen</a></li>'
    : ''
)
.
<<<HTML
        </ul>

HTML
.
($isIngelogd
    ? '<ul class="nav-right">
           <li><a href="profiel.php">Profiel</a></li>'
           . ($rol === 'Customer' ? '<li><a href="winkelmand.php">Winkelmand</a></li>' : '') .
       '</ul>'
    : ''
)
.
<<<HTML
    </nav>
</header>

<main>
HTML;
}
