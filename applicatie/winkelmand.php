<?php
require_once 'components/header.php';
require_once 'components/footer.php';
require_once 'includes/auth.php';
requireRole('Customer');

$header = maakHeader('Winkelmand');
$footer = maakFooter();
?>

<?= $header ?>

<h2>Winkelmand</h2>

<?= $footer ?>
