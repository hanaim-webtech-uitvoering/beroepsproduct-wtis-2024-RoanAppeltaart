<?php
session_start();

// Sessie leegmaken en beëindigen
$_SESSION = [];
session_destroy();

// Terug naar home
header('Location: index.php');
exit;
