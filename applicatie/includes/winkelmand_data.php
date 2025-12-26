<?php
// Sessie starten indien nodig
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Winkelmand initialiseren
function initWinkelmand()
{
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
}

// Item toevoegen aan winkelmand
function voegToeAanWinkelmand($productNaam, $aantal = 1)
{
    initWinkelmand();

    if (!isset($_SESSION['cart'][$productNaam])) {
        $_SESSION['cart'][$productNaam] = 0;
    }

    $_SESSION['cart'][$productNaam] += $aantal;
}

// Aantal instellen (0 = verwijderen)
function zetAantalInWinkelmand($productNaam, $aantal)
{
    initWinkelmand();

    $aantal = (int) $aantal;

    if ($aantal <= 0) {
        unset($_SESSION['cart'][$productNaam]);
        return;
    }

    $_SESSION['cart'][$productNaam] = $aantal;
}

// Item verwijderen
function verwijderUitWinkelmand($productNaam)
{
    initWinkelmand();
    unset($_SESSION['cart'][$productNaam]);
}

// Winkelmand ophalen
function haalWinkelmandOp()
{
    initWinkelmand();
    return $_SESSION['cart'];
}

// Winkelmand leegmaken
function leegWinkelmand()
{
    $_SESSION['cart'] = [];
}
