<?php
// Sessie starten indien nog niet actief
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Controleren of gebruiker is ingelogd
function isIngelogd()
{
    return isset($_SESSION['user']);
}

// Huidige rol ophalen uit sessie
function huidigeRol()
{
    return isset($_SESSION['role']) ? $_SESSION['role'] : '';
}

// Login verplicht stellen
function requireLogin()
{
    if (!isIngelogd()) {
        header('Location: login.php');
        exit;
    }
}

// Specifieke rol verplicht stellen
function requireRole($role)
{
    requireLogin();

    if (huidigeRol() !== $role) {
        header('Location: index.php');
        exit;
    }
}
