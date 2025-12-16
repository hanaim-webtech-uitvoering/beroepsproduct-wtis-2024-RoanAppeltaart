<?php
session_start();

// Alleen POST toestaan
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: login.php');
    exit;
}

require_once 'includes/auth_data.php';

// Invoer ophalen
$username = isset($_POST['username']) ? trim($_POST['username']) : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

// Basisvalidatie
if ($username === '' || $password === '') {
    $_SESSION['login_error'] = 'Vul gebruikersnaam en wachtwoord in.';
    header('Location: login.php');
    exit;
}

// User ophalen uit datalaag
$user = haalUserOp($username);

// Bestaat gebruiker?
if (!$user) {
    $_SESSION['login_error'] = 'Onjuiste inloggegevens.';
    header('Location: login.php');
    exit;
}

// Wachtwoord controleren
if (!password_verify($password, $user['password'])) {
    $_SESSION['login_error'] = 'Onjuiste inloggegevens.';
    header('Location: login.php');
    exit;
}

// Login succesvol → sessie vullen
$_SESSION['user'] = $user['username'];
$_SESSION['role'] = $user['role'];

// Doorsturen
header('Location: index.php');
exit;
