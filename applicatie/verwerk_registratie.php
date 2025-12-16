<?php
require_once 'includes/db_connectie.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: registratie.php');
    exit;
}

$username   = trim($_POST['username']);
$password   = $_POST['password'];
$firstName  = trim($_POST['first_name']);
$lastName   = trim($_POST['last_name']);
$address    = trim($_POST['address']);

$hash = password_hash($password, PASSWORD_DEFAULT);

$db = maakVerbinding();

$sql = 'INSERT INTO dbo.[User]
        (username, password, first_name, last_name, address, role)
        VALUES
        (:username, :password, :first_name, :last_name, :address, :role)';

$stmt = $db->prepare($sql);
$stmt->execute([
    ':username'   => $username,
    ':password'   => $hash,
    ':first_name' => $firstName,
    ':last_name'  => $lastName,
    ':address'    => $address,
    ':role'       => 'Customer'
]);

header('Location: login.php');
exit;
