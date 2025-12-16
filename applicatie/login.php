<?php
// Sessies zijn nodig om foutmeldingen van verwerk_login.php te lezen
session_start();

// Layout components inladen
require_once 'components/header.php';
require_once 'components/footer.php';

// Header en footer voorbereiden
$header = maakHeader('Login');
$footer = maakFooter();

// Foutmelding ophalen uit de sessie (indien aanwezig)
$foutmelding = '';
if (isset($_SESSION['login_error'])) {
    $foutmelding = $_SESSION['login_error'];
    unset($_SESSION['login_error']); // één keer tonen
}
?>

<?= $header ?>

<h2>Login</h2>

<?php if ($foutmelding !== '') { ?>
    <!-- Foutmelding tonen wanneer inloggen mislukt -->
    <p><?= htmlspecialchars($foutmelding) ?></p>
<?php } ?>

<!-- Loginformulier: stuurt gegevens naar de verwerkpagina -->
<form method="post" action="verwerk_login.php">
    <div>
        <label for="username">Gebruikersnaam</label><br>
        <input type="text" id="username" name="username">
    </div>

    <div>
        <label for="password">Wachtwoord</label><br>
        <input type="password" id="password" name="password">
    </div>

    <div>
        <input type="submit" value="Inloggen">
    </div>
</form>

<?= $footer ?>

