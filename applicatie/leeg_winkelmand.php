<?php
require_once 'includes/auth.php';
require_once 'includes/winkelmand_data.php';

// Alleen klanten
requireRole('Customer');

// Winkelmand leegmaken
leegWinkelmand();

// Terug naar winkelmand
header('Location: winkelmand.php');
exit;
