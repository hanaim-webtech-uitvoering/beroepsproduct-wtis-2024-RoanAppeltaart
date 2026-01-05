<?php
require_once 'components/header.php';
require_once 'components/footer.php';

// Header/Footer
$header = maakHeader('Home');
$footer = maakFooter();
?>

<?= $header ?>

<div class="page-center">
    <h2>Welkom</h2>

    <p>Welkom bij Pizzeria Sole Machina. Via het menu kun je producten bekijken en een bestelling plaatsen.</p>

    <p>
        <a href="menu.php">Ga naar het menu</a>
    </p>
</div>

<?= $footer ?>
