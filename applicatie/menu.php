<?php
require_once 'components/header.php';
require_once 'components/footer.php';
require_once 'includes/menu_data.php';

// Header/Footer
$header = maakHeader('Menu');
$footer = maakFooter();

// Menu-items ophalen
$producten = haalMenuItemsOp();

// Groeperen per type
$menuPerType = [];

foreach ($producten as $product) {
    $type = $product['type'] ?: 'Overig';

    if (!isset($menuPerType[$type])) {
        $menuPerType[$type] = [];
    }

    $menuPerType[$type][] = $product;
}
?>

<?= $header ?>

<h2>Menu</h2>

<?php foreach ($menuPerType as $type => $items) { ?>
    <h3><?= htmlspecialchars($type) ?></h3>

    <ul>
        <?php foreach ($items as $product) { ?>
            <li>
                <strong><?= htmlspecialchars($product['name']) ?></strong>
                (€<?= htmlspecialchars($product['price']) ?>)

                <?php if (!empty($product['ingredients'])) { ?>
                    <details>
                        <summary>Ingrediënten</summary>
                        <ul>
                            <?php foreach ($product['ingredients'] as $ingredient) { ?>
                                <li><?= htmlspecialchars($ingredient) ?></li>
                            <?php } ?>
                        </ul>
                    </details>
                <?php } ?>
            </li>
        <?php } ?>
    </ul>
<?php } ?>

<?= $footer ?>
