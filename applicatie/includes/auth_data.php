<?php
require_once 'db_connectie.php';

// Gebruiker ophalen op basis van username
function haalUserOp($username)
{
    // Databaseverbinding
    $db = maakVerbinding();

    // Usergegevens ophalen
    $sql = 'SELECT username, password, role
            FROM dbo.[User]
            WHERE username = :username';

    $query = $db->prepare($sql);
    $query->execute([
        ':username' => $username
    ]);

    // Resultaat teruggeven
    return $query->fetch(PDO::FETCH_ASSOC);
}

// Controleren of username al bestaat
function bestaatUser($username)
{
    // Databaseverbinding
    $db = maakVerbinding();

    // Bestaan van username controleren
    $sql = 'SELECT TOP 1 username
            FROM dbo.[User]
            WHERE username = :username';

    $query = $db->prepare($sql);
    $query->execute([
        ':username' => $username
    ]);

    // True bij bestaand resultaat
    return $query->fetch(PDO::FETCH_ASSOC) ? true : false;
}
