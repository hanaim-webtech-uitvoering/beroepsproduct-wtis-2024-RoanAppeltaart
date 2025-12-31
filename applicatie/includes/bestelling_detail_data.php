<?php
require_once 'db_connectie.php';

function haalBestellingOpVoorKlant($orderId, $username)
{
    // DB-verbinding
    $db = maakVerbinding();

    // Bestelling ophalen (alleen eigen bestelling)
    $sql = "SELECT order_id, datetime, status, address, client_username
            FROM dbo.Pizza_Order
            WHERE order_id = :order_id
              AND client_username = :username";

    $query = $db->prepare($sql);
    $query->execute([
        ':order_id' => (int) $orderId,
        ':username' => $username
    ]);

    return $query->fetch(PDO::FETCH_ASSOC);
}

function haalBestelRegelsOp($orderId)
{
    // DB-verbinding
    $db = maakVerbinding();

    // Regels ophalen
    $sql = "SELECT product_name, quantity
            FROM dbo.Pizza_Order_Product
            WHERE order_id = :order_id
            ORDER BY product_name";

    $query = $db->prepare($sql);
    $query->execute([
        ':order_id' => (int) $orderId
    ]);

    return $query->fetchAll(PDO::FETCH_ASSOC);
}
