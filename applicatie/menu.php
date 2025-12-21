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

<div class="page-center">
    <h2>Menu</h2>

    <?php foreach ($menuPerType as $type => $items) { ?>
        <section class="menu-category">
            <h3><?= htmlspecialchars($type) ?></h3>

            <div class="menu-grid">
                <?php foreach ($items as $product) { ?>
                    <article class="menu-card">
                        <div class="menu-card-top">
                            <strong><?= htmlspecialchars($product['name']) ?></strong>
                            <span class="menu-price">€<?= htmlspecialchars($product['price']) ?></span>
                        </div>

                        <?php if (!empty($product['ingredients'])) { ?>
                            <details class="menu-details">
                                <summary>Ingrediënten</summary>
                                <ul class="menu-ingredients">
                                    <?php foreach ($product['ingredients'] as $ingredient) { ?>
                                        <li><?= htmlspecialchars($ingredient) ?></li>
                                    <?php } ?>
                                </ul>
                            </details>
                        <?php } ?>
                    </article>
                <?php } ?>
            </div>
        </section>
    <?php } ?>
</div>

<?= $footer ?>
