<?php
require_once 'components/header.php';
require_once 'components/footer.php';
require_once 'includes/auth.php';
requireRole('Customer');

$header = maakHeader('Mijn bestellingen');
$footer = maakFooter();
?>

<?= $header ?>

<h2>Mijn bestellingen</h2>

<?= $footer ?>
