<?php
require_once 'components/header.php';
require_once 'components/footer.php';
require_once 'includes/auth.php';
requireRole('Personnel');

$header = maakHeader('Bestelling detail');
$footer = maakFooter();
?>

<?= $header ?>

<h2>Bestelling Details</h2>

<?= $footer ?>
