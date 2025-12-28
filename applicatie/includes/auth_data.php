<?php
require_once 'db_connectie.php';

function haalUserOp($username)
{
    // DB-verbinding
    $db = maakVerbinding();

    // User ophalen
    $sql = 'SELECT username, password, role, address
            FROM dbo.[User]
            WHERE username = :username';

    $query = $db->prepare($sql);
    $query->execute([
        ':username' => $username
    ]);

    return $query->fetch(PDO::FETCH_ASSOC);
}

function bestaatUser($username)
{
    // DB-verbinding
    $db = maakVerbinding();

    // Bestaat user?
    $sql = 'SELECT TOP 1 username
            FROM dbo.[User]
            WHERE username = :username';

    $query = $db->prepare($sql);
    $query->execute([
        ':username' => $username
    ]);

    return $query->fetch(PDO::FETCH_ASSOC) ? true : false;
}

function haalAdresOp($username)
{
    // DB-verbinding
    $db = maakVerbinding();

    // Adres ophalen
    $sql = 'SELECT address
            FROM dbo.[User]
            WHERE username = :username';

    $query = $db->prepare($sql);
    $query->execute([
        ':username' => $username
    ]);

    $row = $query->fetch(PDO::FETCH_ASSOC);

    if (!$row) {
        return '';
    }

    return $row['address'] ? $row['address'] : '';
}

function slaAdresOp($username, $address)
{
    // DB-verbinding
    $db = maakVerbinding();

    // Adres opslaan
    $sql = 'UPDATE dbo.[User]
            SET address = :address
            WHERE username = :username';

    $query = $db->prepare($sql);
    $query->execute([
        ':address' => $address,
        ':username' => $username
    ]);

    return true;
}
