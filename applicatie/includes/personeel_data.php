<?php
require_once 'db_connectie.php';

function haalAlleBestellingenOp()
{
    // DB-verbinding
    $db = maakVerbinding();

    // Bestellingen ophalen
    $sql = "SELECT order_id, datetime, status, client_username, client_name, address
            FROM dbo.Pizza_Order
            ORDER BY datetime DESC";

    $query = $db->query($sql);

    return $query->fetchAll(PDO::FETCH_ASSOC);
}

function updateBestellingStatus($orderId, $status)
{
    // DB-verbinding
    $db = maakVerbinding();

    // Status normaliseren
    $orderId = (int) $orderId;
    $status = (int) $status;

    // Alleen geldige statuswaardes toestaan
    if ($status !== 0 && $status !== 1 && $status !== 2) {
        return false;
    }

    // Status updaten
    $sql = "UPDATE dbo.Pizza_Order
            SET status = :status
            WHERE order_id = :order_id";

    $query = $db->prepare($sql);
    $query->execute([
        ':status' => $status,
        ':order_id' => $orderId
    ]);

    return true;
}
