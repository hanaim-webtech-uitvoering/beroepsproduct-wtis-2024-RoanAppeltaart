<?php
session_start();

require_once 'includes/db_connectie.php';
require_once 'includes/auth_data.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: registratie.php');
    exit;
}

$username  = isset($_POST['username']) ? trim($_POST['username']) : '';
$password  = isset($_POST['password']) ? $_POST['password'] : '';
$firstName = isset($_POST['first_name']) ? trim($_POST['first_name']) : '';
$lastName  = isset($_POST['last_name']) ? trim($_POST['last_name']) : '';
$address   = isset($_POST['address']) ? trim($_POST['address']) : '';

// Server-side validatie: alles verplicht
if ($username === '' || $password === '' || $firstName === '' || $lastName === '' || $address === '') {
    $_SESSION['register_error'] = 'Vul alle velden in.';
    header('Location: registratie.php');
    exit;
}

// Server-side validatie: minimale lengte wachtwoord
if (strlen($password) < 6) {
    $_SESSION['register_error'] = 'Wachtwoord moet minimaal 6 tekens zijn.';
    header('Location: registratie.php');
    exit;
}

// Dubbele username check
if (bestaatUser($username)) {
    $_SESSION['register_error'] = 'Gebruikersnaam bestaat al. Kies een andere.';
    header('Location: registratie.php');
    exit;
}

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
