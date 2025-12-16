<?php
require_once 'includes/db_connectie.php';

$db = maakVerbinding();

$query = $db->query('SELECT username, password FROM [User]');

while ($user = $query->fetch(PDO::FETCH_ASSOC)) {
    $username = $user['username'];
    $password = $user['password'];


    if (strpos($password, '$2y$') !== 0) {
        $hash = password_hash($password, PASSWORD_DEFAULT);

        $update = $db->prepare(
            'UPDATE [User] SET password = :password WHERE username = :username'
        );

        $update->execute([
            ':password' => $hash,
            ':username' => $username
        ]);

        echo "Wachtwoord gehasht voor gebruiker: $username<br>";
    }
}

echo '<br>Klaar.';
