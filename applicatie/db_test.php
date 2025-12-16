<?php
require_once 'includes/db_connectie.php';

$db = maakVerbinding();

$query = 'SELECT TOP 1 username, password, role FROM [User]';
$resultaat = $db->query($query);
$rij = $resultaat->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>DB test</title>
</head>
<body>

<h2>Database test</h2>

<p>
Gebruiker gevonden:
<?= htmlspecialchars($rij['username']) ?>
<p>Role: <?= htmlspecialchars($rij['role']) ?></p>
<p>Password (hash/waarde): <?= htmlspecialchars($rij['password']) ?></p>

</p>

</body>
</html>
