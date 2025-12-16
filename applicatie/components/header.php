<?php
function maakHeader($titel)
{
    return <<<HTML
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>$titel</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<header>
    <h1>Pizzeria Sole Machina</h1>

    <nav>
    <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="menu.php">Menu</a></li>
        <li><a href="winkelmand.php">Winkelmand</a></li>
        <li><a href="bestellingen.php">Bestellingen</a></li>
        <li><a href="profiel.php">Profiel</a></li>
        <li><a href="login.php">Login</a></li>
        <li><a href="privacy.php">Privacy</a></li>
    </ul>
</nav>

</header>

<main>
HTML;
}
