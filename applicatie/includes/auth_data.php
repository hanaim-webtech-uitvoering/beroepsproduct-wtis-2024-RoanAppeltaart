<?php
require_once 'db_connectie.php';

function haalUserOp($username)
{
    $db = maakVerbinding();

    $sql = 'SELECT username, password, role
            FROM [User]
            WHERE username = :username';

    $query = $db->prepare($sql);
    $query->execute([
        ':username' => $username
    ]);

    return $query->fetch(PDO::FETCH_ASSOC);
}
