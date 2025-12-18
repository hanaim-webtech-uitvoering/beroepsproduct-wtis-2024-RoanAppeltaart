<?php
require_once 'db_connectie.php';

// Menu-items ophalen inclusief ingrediënten
function haalMenuItemsOp()
{
    // Databaseverbinding
    $db = maakVerbinding();

    // Producten met ingrediënten ophalen (JOIN op naam)
    $sql = '
        SELECT
            p.name              AS product_name,
            p.price             AS price,
            p.type_id           AS type_name,
            pi.ingredient_name  AS ingredient_name
        FROM dbo.Product p
        LEFT JOIN dbo.Product_Ingredient pi
            ON p.name = pi.product_name
        ORDER BY p.type_id, p.name
    ';

    $stmt = $db->query($sql);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Resultaat groeperen per product
    $producten = [];

    foreach ($rows as $row) {
        $productName = $row['product_name'];

        if (!isset($producten[$productName])) {
            $producten[$productName] = [
                'name' => $row['product_name'],
                'price' => $row['price'],
                'type' => $row['type_name'],
                'ingredients' => []
            ];
        }

        if ($row['ingredient_name'] !== null) {
            $producten[$productName]['ingredients'][] = $row['ingredient_name'];
        }
    }

    return $producten;
}
