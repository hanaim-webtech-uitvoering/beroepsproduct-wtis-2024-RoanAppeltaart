<?php
require_once 'includes/auth.php';
require_once 'includes/winkelmand_data.php';

// Alleen klanten
requireRole('Customer');

// Alleen POST toestaan
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: winkelmand.php');
    exit;
}

// Terug-url bepalen
$redirect = isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== ''
    ? $_SERVER['HTTP_REFERER']
    : 'winkelmand.php';

// Actie bepalen
$action = isset($_POST['action']) ? trim($_POST['action']) : '';

// Product ophalen indien nodig
$product = isset($_POST['product']) ? trim($_POST['product']) : '';

// Aantal ophalen indien nodig
$aantal = isset($_POST['aantal']) ? (int) $_POST['aantal'] : 0;

// Acties afhandelen
switch ($action) {
    case 'toevoegen':
        if ($product !== '') {
            voegToeAanWinkelmand($product);
        }
        header('Location: ' . $redirect);
        exit;

    case 'leegmaken':
        leegWinkelmand();
        header('Location: ' . $redirect);
        exit;

    case 'bijwerken':
        if ($product !== '') {
            zetAantalInWinkelmand($product, $aantal);
        }
        header('Location: ' . $redirect);
        exit;

    default:
        header('Location: winkelmand.php');
        exit;
}
