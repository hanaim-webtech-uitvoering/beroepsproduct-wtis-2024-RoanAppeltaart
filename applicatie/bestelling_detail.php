<?php
require_once 'components/header.php';
require_once 'components/footer.php';
require_once 'includes/auth.php';
require_once 'includes/status_helper.php';
require_once 'includes/bestelling_detail_data.php';

// Alleen klanten
requireRole('Customer');

// Order-id ophalen
$orderId = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($orderId <= 0) {
    header('Location: mijn_bestellingen.php');
    exit;
}

// Bestelling ophalen (alleen eigen)
$username = $_SESSION['user'];
$bestelling = haalBestellingOpVoorKlant($orderId, $username);

if (!$bestelling) {
    header('Location: mijn_bestellingen.php');
    exit;
}

// Orderregels ophalen
$regels = haalBestelRegelsOp($orderId);

// Header/Footer
$header = maakHeader('Bestelling details');
$footer = maakFooter();
?>

<?= $header ?>

<div class="page-center">
    <h2>Bestelling <?= (int) $bestelling['order_id'] ?></h2>

    <p><strong>Datum:</strong> <?= htmlspecialchars($bestelling['datetime']) ?></p>
    <p><strong>Status:</strong> <?= htmlspecialchars(statusTekst($bestelling['status'])) ?></p>
    <p><strong>Afleveradres:</strong> <?= htmlspecialchars($bestelling['address']) ?></p>

    <h3>Producten</h3>

    <?php if (empty($regels)) { ?>
        <p>Geen producten gevonden.</p>
    <?php } else { ?>
        <table>
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Aantal</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($regels as $regel) { ?>
                    <tr>
                        <td><?= htmlspecialchars($regel['product_name']) ?></td>
                        <td><?= (int) $regel['quantity'] ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } ?>

    <p>
        <a href="mijn_bestellingen.php">Terug naar Mijn Bestellingen</a>
    </p>
</div>

<?= $footer ?>
