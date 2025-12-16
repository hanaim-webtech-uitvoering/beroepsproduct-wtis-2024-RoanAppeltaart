<?php
require_once 'components/header.php';
require_once 'components/footer.php';

$header = maakHeader('Registreren');
$footer = maakFooter();
?>

<?= $header ?>

<h2>Registreren</h2>

<form method="post" action="verwerk_registratie.php">
    <div>
        <label for="username">Gebruikersnaam</label><br>
        <input type="text" id="username" name="username" required>
    </div>

    <div>
        <label for="password">Wachtwoord</label><br>
        <input type="password" id="password" name="password" required>
    </div>

    <div>
        <label for="first_name">Voornaam</label><br>
        <input type="text" id="first_name" name="first_name" required>
    </div>

    <div>
        <label for="last_name">Achternaam</label><br>
        <input type="text" id="last_name" name="last_name" required>
    </div>

    <div>
        <label for="address">Adres</label><br>
        <input type="text" id="address" name="address" required>
    </div>

    <div>
        <input type="submit" value="Registreren">
    </div>
</form>

<?= $footer ?>
