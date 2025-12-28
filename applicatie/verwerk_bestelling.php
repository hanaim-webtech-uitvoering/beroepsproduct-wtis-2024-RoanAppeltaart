<?php
require_once 'includes/auth.php';
require_once 'includes/auth_data.php';
require_once 'includes/winkelmand_data.php';
require_once 'includes/bestelling_data.php';

// Alleen klanten
requireRole('Customer');

// Alleen POST toestaan
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: winkelmand.php');
    exit;
}

// Winkelmand ophalen
$cart = haalWinkelmandOp();

if (empty($cart)) {
    header('Location: winkelmand.php');
    exit;
}

// Klantgegevens
$clientUsername = $_SESSION['user'];

// Adres uit DB proberen
$addressDb = haalAdresOp($clientUsername);

if ($addressDb !== '') {
    $address = $addressDb;
} else {
    // Adres uit POST verplicht als er nog niets is opgeslagen
    $address = isset($_POST['address']) ? trim($_POST['address']) : '';

    if ($address === '') {
        $_SESSION['bestel_error'] = 'Vul een afleveradres in.';
        header('Location: winkelmand.php');
        exit;
    }

    // Adres opslaan voor volgende keer
    slaAdresOp($clientUsername, $address);
}

// Bestelling plaatsen (nieuwe signature)
$orderId = plaatsBestelling($clientUsername, $address, $cart);

if (!$orderId || (int) $orderId <= 0) {
    $_SESSION['bestel_error'] = 'Bestelling plaatsen is mislukt.';
    header('Location: winkelmand.php');
    exit;
}

// Winkelmand leegmaken
leegWinkelmand();

// Succesmelding
$_SESSION['bestel_success'] = 'Bestelling geplaatst. Bestelnummer: ' . (int) $orderId;

// Doorsturen
header('Location: mijn_bestellingen.php');
exit;
