<?php
require_once 'components/header.php';
require_once 'components/footer.php';
require_once 'includes/auth.php';
require_once 'includes/status_helper.php';
require_once 'includes/bestelling_detail_data.php';

// Alleen personeel
requireRole('Personnel');

// Status-foutmelding ophalen
$statusError = isset($_SESSION['status_error']) ? $_SESSION['status_error'] : '';
unset($_SESSION['status_error']);

// Order-id ophalen
$orderId = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($orderId <= 0) {
    header('Location: personeel.php');
    exit;
}

// Bestelling ophalen
$bestelling = haalBestellingOp($orderId);

if (!$bestelling) {
    header('Location: personeel.php');
    exit;
}

// Orderregels ophalen
$regels = haalBestelRegelsOp($orderId);

// Header/Footer
$header = maakHeader('Bestelling details');
$footer = maakFooter();

// Huidige status
$huidigeStatus = (int) $bestelling['status'];
?>

<?= $header ?>

<div class="page-center">
    <h2>Bestelling <?= (int) $bestelling['order_id'] ?></h2>

    <p><strong>Datum:</strong> <?= htmlspecialchars($bestelling['datetime']) ?></p>
    <p><strong>Status:</strong> <?= htmlspecialchars(statusTekst($bestelling['status'])) ?></p>
    <p><strong>Klant:</strong> <?= htmlspecialchars($bestelling['client_name']) ?></p>
    <p><strong>Afleveradres:</strong> <?= htmlspecialchars($bestelling['address']) ?></p>

    <h3>Status aanpassen</h3>

    <?php if ($statusError !== '') { ?>
        <p><?= htmlspecialchars($statusError) ?></p>
    <?php } ?>

    <form method="post" action="verwerk_status.php">
        <input type="hidden" name="order_id" value="<?= (int) $bestelling['order_id'] ?>">

        <label for="status">Status</label>
        <select name="status" id="status">
            <option value="0" <?= $huidigeStatus === 0 ? 'selected' : '' ?>>Nieuw</option>
            <option value="1" <?= $huidigeStatus === 1 ? 'selected' : '' ?>>In behandeling</option>
            <option value="2" <?= $huidigeStatus === 2 ? 'selected' : '' ?>>Bezorgd</option>
        </select>

        <input type="submit" value="Opslaan">
    </form>

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
        <a href="personeel.php">Terug naar Bestellingen</a>
    </p>
</div>

<?= $footer ?>
