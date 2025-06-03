<?php
require_once "db_connectie.php";
session_start();

// // Redirect als al ingelogd
// if (isset($_SESSION['rol'])) {
//     if ($_SESSION['rol'] === 'client') {
//         header("Location: home.php");
//     } else if ($_SESSION['rol'] === 'personnel') {
//         header("Location: home.php");
//     }
//     exit();
// }

// ---- HULPFUNCTIE REGISTRATIE ----
function registreerGebruiker($gebruikersnaam, $wachtwoord, $voornaam, $achternaam, $adres, $rol = 'client') {
    $conn = maakVerbinding();
    $hash = password_hash($wachtwoord, PASSWORD_DEFAULT);
    $rol = !empty($rol) ? $rol : 'client';

    $query = "INSERT INTO [dbo].[User] (username, password, first_name, last_name, role, address) 
              VALUES (:username, :password, :first_name, :last_name, :role, :address)";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':username', $gebruikersnaam);
    $stmt->bindParam(':password', $hash);
    $stmt->bindParam(':first_name', $voornaam);
    $stmt->bindParam(':last_name', $achternaam);
    $stmt->bindParam(':role', $rol);
    $stmt->bindParam(':address', $adres);

    try {
        $stmt->execute();
        $_SESSION['username'] = $gebruikersnaam;
        $_SESSION['voornaam'] = $voornaam;
        $_SESSION['achternaam'] = $achternaam;
        $_SESSION['adres'] = $adres;
        $_SESSION['rol'] = $rol;
    } catch (PDOException $e) {
        return "Registratie mislukt: " . $e->getMessage();
    }
    return "";
}

// ---- HULPFUNCTIE LOGIN ----
function loginGebruiker($gebruikersnaam, $wachtwoord) {
    $conn = maakVerbinding();
    $query = "SELECT * FROM [dbo].[User] WHERE username = :username";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':username', $gebruikersnaam);

    try {
        $stmt->execute();
        $gebruiker = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($gebruiker && password_verify($wachtwoord, $gebruiker['password']) || $wachtwoord == $gebruiker['password'] ) {
            $_SESSION['username'] = $gebruiker['username'];
            $_SESSION['voornaam'] = $gebruiker['first_name'];
            $_SESSION['achternaam'] = $gebruiker['last_name'];
            $_SESSION['adres'] = $gebruiker['address'];
            $_SESSION['rol'] = strtolower($gebruiker['role']);
            return true;
        }
    } catch (PDOException $e) {
        return false;
    }
    return false;
}

// ---- FOUTMELDINGEN ----
$registratieError = "";
$loginErrorKlant = "";
$loginErrorMedewerker = "";

// ---- FORMULIEREN VERWERKEN ----
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['actie']) && $_POST['actie'] === 'registreren') {
        $gebruikersnaam = $_POST['reg_username'] ?? '';
        $wachtwoord = $_POST['reg_password'] ?? '';
        $voornaam = $_POST['reg_firstname'] ?? '';
        $achternaam = $_POST['reg_lastname'] ?? '';
        $adres = $_POST['reg_adres'] ?? '';

        if (empty($gebruikersnaam) || empty($wachtwoord) || empty($voornaam) || empty($achternaam) || empty($adres)) {
            $registratieError = "Vul alle verplichte velden in.";
        } else {
            $fout = registreerGebruiker($gebruikersnaam, $wachtwoord, $voornaam, $achternaam, $adres);
            if ($fout === "") {
                header("Location: home.php");
                exit();
            } else {
                $registratieError = $fout;
            }
        }
    } elseif (isset($_POST['actie']) && $_POST['actie'] === 'inloggen') {
        $rol = $_POST['login_rol'] ?? '';
        $gebruikersnaam = $_POST['login_username'] ?? '';
        $wachtwoord = $_POST['login_password'] ?? '';

        if (loginGebruiker($gebruikersnaam, $wachtwoord)) {
            if ($_SESSION['rol'] === "client") {
                header("Location: home.php");
            } else {
                header("Location: home.php");
            }
            exit();
        } else {
            if ($rol === "klant") {
                $loginErrorKlant = "Ongeldige gebruikersnaam of wachtwoord.";
            } else {
                $loginErrorMedewerker = "Ongeldige gebruikersnaam of wachtwoord.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Pizzeria Sole Machina - Home</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
    <h1>Pizzeria Sole Machina</h1>
    <nav>
        <a href="index.php">Home</a>
        <a href="Menu.php">Menu</a>
        <a href="Privacyverklaring.php">Privacyverklaring</a>
    </nav>
</header>
<main>
    <!-- Login Tabs -->
    <div class="login-tabs">
        <button type="button" onclick="showTab('klant')">Klant login</button>
        <button type="button" onclick="showTab('medewerker')">Medewerker login</button>
        <button type="button" onclick="showTab('register')">Registreren</button>
    </div>

    <!-- Klant login -->
    <div id="klant" class="tabcontent">
        <h2>Klant login</h2>
        <?php if ($loginErrorKlant): ?>
            <div style="color:red"><?= htmlspecialchars($loginErrorKlant) ?></div>
        <?php endif; ?>
        <form action="" method="post">
            <input type="hidden" name="actie" value="inloggen">
            <input type="hidden" name="login_rol" value="klant">
            <label for="klant-username">Gebruikersnaam:</label>
            <input type="text" name="login_username" id="klant-username" required>
            <label for="klant-password">Wachtwoord:</label>
            <input type="password" name="login_password" id="klant-password" required>
            <button type="submit">Inloggen</button>
        </form>
    </div>

    <!-- Medewerker login -->
    <div id="medewerker" class="tabcontent" style="display:none;">
        <h2>Medewerker login</h2>
        <?php if ($loginErrorMedewerker): ?>
            <div style="color:red"><?= htmlspecialchars($loginErrorMedewerker) ?></div>
        <?php endif; ?>
        <form action="" method="post">
            <input type="hidden" name="actie" value="inloggen">
            <input type="hidden" name="login_rol" value="medewerker">
            <label for="medewerker-username">Gebruikersnaam:</label>
            <input type="text" name="login_username" id="medewerker-username" required>
            <label for="medewerker-password">Wachtwoord:</label>
            <input type="password" name="login_password" id="medewerker-password" required>
            <button type="submit">Inloggen</button>
        </form>
    </div>

    <!-- Registratieformulier -->
    <div id="register" class="tabcontent" style="display:none;">
        <h2>Registreren</h2>
        <?php if ($registratieError): ?>
            <div style="color:red"><?= htmlspecialchars($registratieError) ?></div>
        <?php endif; ?>
        <form action="" method="post">
            <input type="hidden" name="actie" value="registreren">
            <label for="reg_username">Gebruikersnaam:</label>
            <input type="text" name="reg_username" id="reg_username" required>
            <label for="reg_password">Wachtwoord:</label>
            <input type="password" name="reg_password" id="reg_password" required>
            <label for="reg_firstname">Voornaam:</label>
            <input type="text" name="reg_firstname" id="reg_firstname" required>
            <label for="reg_lastname">Achternaam:</label>
            <input type="text" name="reg_lastname" id="reg_lastname" required>
            <label for="reg_adres">Adres:</label>
            <input type="text" name="reg_adres" id="reg_adres" required>
            <button type="submit">Registreren</button>
        </form>
    </div>
</main>
<script>
    function showTab(tab) {
        document.getElementById('klant').style.display = (tab === 'klant') ? 'block' : 'none';
        document.getElementById('medewerker').style.display = (tab === 'medewerker') ? 'block' : 'none';
        document.getElementById('register').style.display = (tab === 'register') ? 'block' : 'none';
    }
    // Toon standaard klant-login
    showTab('klant');
</script>
</body>
</html>
