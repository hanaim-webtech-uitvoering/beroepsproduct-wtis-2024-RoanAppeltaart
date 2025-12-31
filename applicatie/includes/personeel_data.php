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
