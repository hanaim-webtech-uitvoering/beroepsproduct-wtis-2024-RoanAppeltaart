<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function isIngelogd()
{
    return isset($_SESSION['user']);
}

function huidigeRol()
{
    return isset($_SESSION['role']) ? $_SESSION['role'] : '';
}

function requireLogin()
{
    if (!isIngelogd()) {
        header('Location: login.php');
        exit;
    }
}

function requireRole($role)
{
    requireLogin();

    if (huidigeRol() !== $role) {
        header('Location: index.php');
        exit;
    }
}
