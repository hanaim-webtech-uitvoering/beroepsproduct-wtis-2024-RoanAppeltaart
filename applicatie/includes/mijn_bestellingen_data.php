<?php
require_once 'db_connectie.php';

function haalBestellingenVanKlantOp($username)
{
    // DB-verbinding
    $db = maakVerbinding();

    // Bestellingen ophalen
    $sql = "SELECT order_id, datetime, status, address
            FROM dbo.Pizza_Order
            WHERE client_username = :username
            ORDER BY datetime DESC";

    $query = $db->prepare($sql);
    $query->execute([
        ':username' => $username
    ]);

    return $query->fetchAll(PDO::FETCH_ASSOC);
}
