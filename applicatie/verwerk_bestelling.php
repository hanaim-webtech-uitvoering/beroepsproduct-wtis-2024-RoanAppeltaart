<?php
require_once 'includes/auth.php';
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

// Adres ophalen
$address = isset($_POST['address']) ? trim($_POST['address']) : '';

if ($address === '') {
    $_SESSION['bestel_error'] = 'Vul een afleveradres in.';
    header('Location: winkelmand.php');
    exit;
}

// Gegevens klant
$clientUsername = $_SESSION['user'];
$clientName = $_SESSION['user'];

// Bestelling plaatsen
$orderId = plaatsBestelling($clientUsername, $clientName, $address, $cart);

if ($orderId <= 0) {
    $_SESSION['bestel_error'] = 'Bestelling plaatsen is mislukt.';
    header('Location: winkelmand.php');
    exit;
}

// Winkelmand leegmaken
leegWinkelmand();

// Succesmelding
$_SESSION['bestel_success'] = 'Bestelling geplaatst. Bestelnummer: ' . $orderId;

// Doorsturen
header('Location: mijn_bestellingen.php');
exit;
