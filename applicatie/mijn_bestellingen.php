<?php
require_once 'components/header.php';
require_once 'components/footer.php';
require_once 'includes/auth.php';
require_once 'includes/mijn_bestellingen_data.php';
require_once 'includes/status_helper.php';

// Alleen klanten
requireRole('Customer');

// Header/Footer
$header = maakHeader('Mijn Bestellingen');
$footer = maakFooter();

// Bestellingen ophalen
$username = $_SESSION['user'];
$bestellingen = haalBestellingenVanKlantOp($username);
?>

<?= $header ?>

<div class="page-center">
    <h2>Mijn Bestellingen</h2>

    <?php if (empty($bestellingen)) { ?>
        <p>Je hebt nog geen bestellingen geplaatst.</p>
    <?php } else { ?>
        <table>
            <thead>
                <tr>
                    <th>Bestelnummer</th>
                    <th>Datum</th>
                    <th>Status</th>
                    <th>Adres</th>
                    <th>Details</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($bestellingen as $bestelling) { ?>
                    <tr>
                        <td><?= (int) $bestelling['order_id'] ?></td>
                        <td><?= htmlspecialchars($bestelling['datetime']) ?></td>
                        <td><?= htmlspecialchars(statusTekst($bestelling['status'])) ?></td>
                        <td><?= htmlspecialchars($bestelling['address']) ?></td>
                        <td>
                            <a href="bestelling_detail.php?id=<?= (int) $bestelling['order_id'] ?>">
                                Bekijk
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } ?>
</div>

<?= $footer ?>
