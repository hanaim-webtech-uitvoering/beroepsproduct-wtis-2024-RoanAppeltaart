<?php
require_once 'components/header.php';
require_once 'components/footer.php';
require_once 'includes/auth.php';
requireRole('Personnel');

$header = maakHeader('Bestellingen');
$footer = maakFooter();
?>

<?= $header ?>

<h2>Bestellingen</h2>

<?= $footer ?>
