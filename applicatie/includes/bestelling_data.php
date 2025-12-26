<?php
require_once 'db_connectie.php';

function kiesPersoneelUsername()
{
    // DB-verbinding
    $db = maakVerbinding();

    // 1 personeelsaccount pakken
    $sql = "SELECT TOP 1 username
            FROM dbo.[User]
            WHERE role = 'Personnel'
            ORDER BY username";

    $query = $db->query($sql);
    $row = $query->fetch(PDO::FETCH_ASSOC);

    return $row ? $row['username'] : '';
}

function plaatsBestelling($clientUsername, $clientName, $address, $winkelmand)
{
    // DB-verbinding
    $db = maakVerbinding();

    // Personeel koppelen
    $personnelUsername = kiesPersoneelUsername();

    // Transactie
    $db->beginTransaction();

    try {
        // Bestelling opslaan
        $sqlOrder = "INSERT INTO dbo.Pizza_Order (client_username, client_name, personnel_username, datetime, status, address)
                     VALUES (:client_username, :client_name, :personnel_username, GETDATE(), :status, :address);

                     SELECT SCOPE_IDENTITY() AS order_id;";

        $queryOrder = $db->prepare($sqlOrder);
        $queryOrder->execute([
            ':client_username' => $clientUsername,
            ':client_name' => $clientName,
            ':personnel_username' => $personnelUsername,
            ':status' => 0,
            ':address' => $address
        ]);

        $orderRow = $queryOrder->fetch(PDO::FETCH_ASSOC);
        $orderId = $orderRow ? (int) $orderRow['order_id'] : 0;

        // Orderregels opslaan
        $sqlItem = "INSERT INTO dbo.Pizza_Order_Product (order_id, product_name, quantity)
                    VALUES (:order_id, :product_name, :quantity)";

        $queryItem = $db->prepare($sqlItem);

        foreach ($winkelmand as $productNaam => $aantal) {
            $queryItem->execute([
                ':order_id' => $orderId,
                ':product_name' => $productNaam,
                ':quantity' => (int) $aantal
            ]);
        }

        // Commit
        $db->commit();

        return $orderId;
    } catch (Exception $e) {
        // Rollback
        $db->rollBack();
        return 0;
    }
}
