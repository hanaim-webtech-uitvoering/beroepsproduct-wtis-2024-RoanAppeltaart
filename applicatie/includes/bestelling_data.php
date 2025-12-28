<?php
require_once 'db_connectie.php';

function plaatsBestelling($clientUsername, $adres, $winkelmand)
{
    if (empty($winkelmand) || !is_array($winkelmand)) {
        return false;
    }

    $db = maakVerbinding();
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    try {
        $db->beginTransaction();

        // Klantnaam ophalen
        $sqlNaam = 'SELECT first_name, last_name
                    FROM dbo.[User]
                    WHERE username = :username';
        $qNaam = $db->prepare($sqlNaam);
        $qNaam->execute([':username' => $clientUsername]);
        $naamRij = $qNaam->fetch(PDO::FETCH_ASSOC);

        $clientName = $clientUsername;
        if ($naamRij) {
            $samengesteld = trim(($naamRij['first_name'] ?? '') . ' ' . ($naamRij['last_name'] ?? ''));
            if ($samengesteld !== '') {
                $clientName = $samengesteld;
            }
        }

        // Personeel kiezen
        $sqlPersoneel = "SELECT TOP 1 username
                         FROM dbo.[User]
                         WHERE role = 'Personnel'
                         ORDER BY username";
        $personeel = $db->query($sqlPersoneel)->fetch(PDO::FETCH_ASSOC);

        if (!$personeel || !isset($personeel['username'])) {
            $db->rollBack();
            return false;
        }

        $personnelUsername = $personeel['username'];

        // Bestelling opslaan + order_id ophalen
        $sqlOrder = '
            INSERT INTO dbo.Pizza_Order
            (client_username, client_name, personnel_username, [datetime], status, address)
            OUTPUT INSERTED.order_id
            VALUES
            (:client_username, :client_name, :personnel_username, GETDATE(), :status, :address)
        ';

        $qOrder = $db->prepare($sqlOrder);
        $qOrder->execute([
            ':client_username' => $clientUsername,
            ':client_name' => $clientName,
            ':personnel_username' => $personnelUsername,
            ':status' => 0,
            ':address' => $adres
        ]);

        $orderId = (int) $qOrder->fetchColumn();

        if ($orderId <= 0) {
            $db->rollBack();
            return false;
        }

        // Orderregels opslaan
        $sqlRegel = '
            INSERT INTO dbo.Pizza_Order_Product
            (order_id, product_name, quantity)
            VALUES
            (:order_id, :product_name, :quantity)
        ';
        $qRegel = $db->prepare($sqlRegel);

        foreach ($winkelmand as $productNaam => $aantal) {
            $aantal = (int) $aantal;
            if ($aantal <= 0) {
                continue;
            }

            $qRegel->execute([
                ':order_id' => $orderId,
                ':product_name' => $productNaam,
                ':quantity' => $aantal
            ]);
        }

        $db->commit();
        return $orderId;

    } catch (PDOException $e) {
        if ($db->inTransaction()) {
            $db->rollBack();
        }
        return false;
    }
}
