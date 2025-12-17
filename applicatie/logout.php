<?php
session_start();

// Alle sessiegegevens verwijderen
$_SESSION = [];

// Sessiecook ie verwijderen
if (ini_get('session.use_cookies')) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params['path'],
        $params['domain'],
        $params['secure'],
        $params['httponly']
    );
}

// Sessie vernietigen
session_destroy();

// Terug naar home
header('Location: index.php');
exit;
