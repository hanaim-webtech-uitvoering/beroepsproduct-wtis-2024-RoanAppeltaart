<?php
require_once 'includes/auth.php';
require_once 'includes/personeel_data.php';

// Alleen personeel
requireRole('Personnel');

// Alleen POST toestaan
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: personeel.php');
    exit;
}

// Invoer ophalen
$orderId = isset($_POST['order_id']) ? (int) $_POST['order_id'] : 0;
$status = isset($_POST['status']) ? (int) $_POST['status'] : -1;

if ($orderId <= 0) {
    header('Location: personeel.php');
    exit;
}

// Status updaten
$ok = updateBestellingStatus($orderId, $status);

if (!$ok) {
    $_SESSION['status_error'] = 'Status aanpassen is mislukt.';
}

// Terug naar detail
header('Location: bestelling_detail.php?id=' . $orderId);
exit;
