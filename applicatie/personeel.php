<?php
require_once 'components/header.php';
require_once 'components/footer.php';
require_once 'includes/auth.php';
require_once 'includes/personeel_data.php';
require_once 'includes/status_helper.php';

// Alleen personeel
requireRole('Personnel');

// Header/Footer
$header = maakHeader('Bestellingen');
$footer = maakFooter();

// Bestellingen ophalen
$bestellingen = haalAlleBestellingenOp();

// Sorteren: status (0,1,2) en daarna datum desc
usort($bestellingen, function ($a, $b) {
    $statusA = (int) $a['status'];
    $statusB = (int) $b['status'];

    if ($statusA !== $statusB) {
        return $statusA <=> $statusB;
    }

    $tijdA = strtotime($a['datetime']);
    $tijdB = strtotime($b['datetime']);

    return $tijdB <=> $tijdA;
});
?>

<?= $header ?>

<div class="page-center">
    <h2>Bestellingen</h2>

    <?php if (empty($bestellingen)) { ?>
        <p>Er zijn geen bestellingen.</p>
    <?php } else { ?>
        <table>
            <thead>
                <tr>
                    <th>Bestelnummer</th>
                    <th>Datum</th>
                    <th>Klant</th>
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
                        <td><?= htmlspecialchars($bestelling['client_name']) ?></td>
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
