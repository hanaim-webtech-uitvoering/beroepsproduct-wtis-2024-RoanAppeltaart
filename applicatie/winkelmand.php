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
?>

<?= $header ?>

<h2>Winkelmand</h2>

<?php if (empty($cart)) { ?>
    <p>Je winkelmand is leeg.</p>
<?php } else { ?>
    <table>
        <thead>
            <tr>
                <th>Product</th>
                <th>Aantal</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($cart as $productNaam => $aantal) { ?>
                <tr>
                    <td><?= htmlspecialchars($productNaam) ?></td>
                    <td><?= htmlspecialchars($aantal) ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <form method="post" action="verwerk_winkelmand.php">
        <input type="hidden" name="action" value="leegmaken">
        <input type="submit" value="Winkelmand leegmaken">
    </form>
<?php } ?>

<?= $footer ?>
