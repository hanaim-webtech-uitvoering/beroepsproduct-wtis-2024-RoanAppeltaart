<?php
require_once 'components/header.php';
require_once 'components/footer.php';
require_once 'includes/auth.php';
require_once 'includes/auth_data.php';

// Ingelogd vereist
requireLogin();

// Header/Footer
$header = maakHeader('Profiel');
$footer = maakFooter();

// User ophalen
$username = $_SESSION['user'];
$user = haalUserOp($username);

if (!$user) {
    header('Location: index.php');
    exit;
}

// Gegevens
$rol = isset($user['role']) ? $user['role'] : '';
$voornaam = isset($user['first_name']) ? $user['first_name'] : '';
$achternaam = isset($user['last_name']) ? $user['last_name'] : '';
$adres = isset($user['address']) ? $user['address'] : '';
?>

<?= $header ?>

<div class="page-center">
    <h2>Profiel</h2>

    <p><strong>Gebruikersnaam:</strong> <?= htmlspecialchars($username) ?></p>
    <p><strong>Rol:</strong> <?= htmlspecialchars($rol) ?></p>

    <?php if (trim($voornaam . $achternaam) !== '') { ?>
        <p><strong>Naam:</strong> <?= htmlspecialchars(trim($voornaam . ' ' . $achternaam)) ?></p>
    <?php } ?>

    <?php if ($adres !== '') { ?>
        <p><strong>Adres:</strong> <?= htmlspecialchars($adres) ?></p>
    <?php } ?>
</div>

<?= $footer ?>
