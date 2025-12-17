<?php
require_once 'components/header.php';
require_once 'components/footer.php';
require_once 'includes/auth.php';
requireLogin();

$header = maakHeader('Profiel');
$footer = maakFooter();
?>

<?= $header ?>

<h2>Profiel</h2>

<?= $footer ?>
