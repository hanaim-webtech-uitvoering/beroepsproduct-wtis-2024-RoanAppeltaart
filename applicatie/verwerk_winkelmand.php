<?php
require_once 'includes/auth.php';
require_once 'includes/winkelmand_data.php';

// Alleen klanten
requireRole('Customer');

// Alleen POST toestaan
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: menu.php');
    exit;
}

// Product ophalen
$product = isset($_POST['product']) ? trim($_POST['product']) : '';

if ($product === '') {
    header('Location: menu.php');
    exit;
}

// Toevoegen aan winkelmand
voegToeAanWinkelmand($product);

// Terug naar menu
header('Location: menu.php');
exit;
