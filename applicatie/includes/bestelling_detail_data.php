<?php
require_once 'db_connectie.php';

function haalBestellingOp($orderId)
{
    // DB-verbinding
    $db = maakVerbinding();

    // Bestelling ophalen
    $sql = "SELECT order_id, datetime, status, address, client_username, client_name, personnel_username
            FROM dbo.Pizza_Order
            WHERE order_id = :order_id";

    $query = $db->prepare($sql);
    $query->execute([
        ':order_id' => (int) $orderId
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
