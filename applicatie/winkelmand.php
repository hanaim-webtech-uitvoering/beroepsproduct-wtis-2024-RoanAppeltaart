<?php
require_once 'components/header.php';
require_once 'components/footer.php';
require_once 'includes/auth.php';
require_once 'includes/winkelmand_data.php';

// Alleen klanten
requireRole('Customer');

// Header/Footer
$header = maakHeader('Winkelmand');
$footer = maakFooter();

// Winkelmand ophalen
$cart = haalWinkelmandOp();

// Bestel-foutmelding ophalen
$bestelError = isset($_SESSION['bestel_error']) ? $_SESSION['bestel_error'] : '';
unset($_SESSION['bestel_error']);
?>

<?= $header ?>

<h2>Winkelmand</h2>

<p>
    <a href="menu.php">Verder winkelen</a>
</p>

<?php if (empty($cart)) { ?>
    <p>Je winkelmand is leeg.</p>
<?php } else { ?>
    <table>
        <thead>
            <tr>
                <th>Product</th>
                <th>Aantal</th>
                <th>Aanpassen</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($cart as $productNaam => $aantal) { ?>
                <tr>
                    <td><?= htmlspecialchars($productNaam) ?></td>
                    <td><?= (int) $aantal ?></td>
                    <td>
                        <form method="post" action="verwerk_winkelmand.php" style="display:inline-block;">
                            <input type="hidden" name="action" value="bijwerken">
                            <input type="hidden" name="product" value="<?= htmlspecialchars($productNaam) ?>">
                            <input type="hidden" name="aantal" value="<?= (int) $aantal + 1 ?>">
                            <button type="submit">+</button>
                        </form>

                        <form method="post" action="verwerk_winkelmand.php" style="display:inline-block;">
                            <input type="hidden" name="action" value="bijwerken">
                            <input type="hidden" name="product" value="<?= htmlspecialchars($productNaam) ?>">
                            <input type="hidden" name="aantal" value="<?= (int) $aantal - 1 ?>">
                            <button type="submit">-</button>
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <form method="post" action="verwerk_winkelmand.php">
        <input type="hidden" name="action" value="leegmaken">
        <input type="submit" value="Winkelmand leegmaken">
    </form>

    <h3>Bestellen</h3>

    <?php if ($bestelError !== '') { ?>
        <p><?= htmlspecialchars($bestelError) ?></p>
    <?php } ?>

    <form method="post" action="verwerk_bestelling.php">
        <label for="address">Afleveradres</label>
        <input type="text" name="address" id="address">
        <input type="submit" value="Bestellen">
    </form>
<?php } ?>

<?= $footer ?>
