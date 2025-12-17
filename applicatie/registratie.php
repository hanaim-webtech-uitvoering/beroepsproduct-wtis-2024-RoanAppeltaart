<?php
session_start();

require_once 'components/header.php';
require_once 'components/footer.php';

$header = maakHeader('Registreren');
$footer = maakFooter();

// Foutmelding uit sessie ophalen
$foutmelding = '';
if (isset($_SESSION['register_error'])) {
    $foutmelding = $_SESSION['register_error'];
    unset($_SESSION['register_error']);
}
?>

<?= $header ?>

<h2>Registreren</h2>

<form method="post" action="verwerk_registratie.php">
    <div>
        <label for="username">Gebruikersnaam</label><br>
        <input type="text" id="username" name="username">
    </div>

    <div>
        <label for="password">Wachtwoord</label><br>
        <input type="password" id="password" name="password">
    </div>

    <div>
        <label for="first_name">Voornaam</label><br>
        <input type="text" id="first_name" name="first_name">
    </div>

    <div>
        <label for="last_name">Achternaam</label><br>
        <input type="text" id="last_name" name="last_name">
    </div>

    <div>
        <label for="address">Adres</label><br>
        <input type="text" id="address" name="address">
    </div>

    <div>
        <input type="submit" value="Registreren">
    </div>
</form>

<?php if ($foutmelding !== '') { ?>
    <p><?= htmlspecialchars($foutmelding) ?></p>
<?php } ?>

<?= $footer ?>
