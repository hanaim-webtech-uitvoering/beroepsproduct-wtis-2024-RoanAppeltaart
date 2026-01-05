<?php
require_once 'components/header.php';
require_once 'components/footer.php';

// Header/Footer
$header = maakHeader('Privacy');
$footer = maakFooter();
?>

<?= $header ?>

<div class="page-center">
    <h2>Privacyverklaring</h2>

    <p>
        Pizzeria Sole Machina verwerkt persoonsgegevens uitsluitend voor het uitvoeren van bestellingen.
        Hierbij gaat het om gegevens zoals gebruikersnaam, naam en afleveradres.
    </p>

    <p>
        Deze gegevens worden niet gedeeld met derden en worden alleen gebruikt binnen deze applicatie.
    </p>

    <p>
        Gebruikers kunnen hun gegevens inzien via hun profielpagina.
    </p>
</div>

<?= $footer ?>
