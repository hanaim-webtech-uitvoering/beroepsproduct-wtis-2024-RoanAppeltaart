<?php
session_start();

require_once 'components/header.php';
require_once 'components/footer.php';

$header = maakHeader('Login');
$footer = maakFooter();

$foutmelding = '';
if (isset($_SESSION['login_error'])) {
    $foutmelding = $_SESSION['login_error'];
    unset($_SESSION['login_error']);
}
?>

<?= $header ?>

<h2>Login</h2>

<?php if ($foutmelding !== '') { ?>
    <p><?= htmlspecialchars($foutmelding) ?></p>
<?php } ?>

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

<p>
    Nog geen account?
    <a href="registratie.php">Registreren</a>
</p>

<?= $footer ?>

