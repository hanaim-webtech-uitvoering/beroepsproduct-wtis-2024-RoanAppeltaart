<?php
require_once '../includes/db_connectie.php';

// Databaseverbinding
$db = maakVerbinding();

// Alle gebruikers ophalen
$sql = 'SELECT username, password
        FROM dbo.[User]';

$stmt = $db->query($sql);
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($users as $user) {
    // Alleen plain-text wachtwoorden hashen
    if (password_get_info($user['password'])['algo'] === 0) {
        $hash = password_hash($user['password'], PASSWORD_DEFAULT);

        $updateSql = 'UPDATE dbo.[User]
                      SET password = :password
                      WHERE username = :username';

        $updateStmt = $db->prepare($updateSql);
        $updateStmt->execute([
            ':password' => $hash,
            ':username' => $user['username']
        ]);
    }
}

echo 'Testdata wachtwoorden zijn gehasht.';
