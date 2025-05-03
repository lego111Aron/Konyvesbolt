<?php
include "../Back-End/authentication/base.php";

// Ellenőrizzük, hogy van-e bejelentkezett felhasználó
if (!sessionTest()) {
    // Ha nincs bejelentkezve a felhasználó, átirányítjuk a bejelentkezési oldalra
    header("Location: login.php");
    exit();
}

// Bejelentkezett felhasználó adatainak lekérése az adatbázisból
$username = $_SESSION["username"];

// Kapcsolódás az adatbázishoz
include "../Back-End/connect.php";

// Lekérdezzük a felhasználó adatokat
$query = "SELECT * FROM FELHASZNALO WHERE FELHASZNALONEV = :username";
$stmt = oci_parse($conn, $query);
oci_bind_by_name($stmt, ":username", $username);
oci_execute($stmt);
$user = oci_fetch_assoc($stmt);

// Zárjuk le a kapcsolatot
oci_free_statement($stmt);
oci_close($conn);
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book25</title>
    <link rel="stylesheet" href="StyleSheets/style.css">
</head>

<body id="profileBody">

    <!-- Fejléc -->
    <div class="topbar">
        <div class="logo"><a href="index.php">BOOK<span>25</span>.hu</a></div>
        <div class="login"><a href="login.php">Bejelentkezés</a></div>
    </div>

    <!-- Menü -->
    <div class="navbar">
        <a href="index.php">Főoldal</a>
        <a href="books.php">Könyvek</a>
        <a href="authors.php">Kiadók</a>
        <a href="shops.php">Áruházak</a>
        <a href="#">Statisztikák</a>
    </div>

    <form class="profile-form-container" method="post" action="../Back-End/authentication/update_data.php">
        <h2>Fiók adatok</h2>
    
        <div class="profile-grid-container">
            <div class="profileform-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" value="<?= htmlspecialchars($user['EMAIL']) ?>">
            </div>
    
            <div class="profileform-group">
                <label for="username">Felhasználónév</label>
                <input type="text" name="username" id="username" value="<?= htmlspecialchars($user['FELHASZNALONEV']) ?>" readonly>
            </div>
    
            <div class="profileform-group">
                <label for="phone">Telefon</label>
                <input type="tel" name="phone" id="phone" placeholder="Telefonszám" pattern="^06\d{2}\d{3}\d{4}$" value="<?= htmlspecialchars($user['TELEFON']) ?>">
            </div>
    
            <div class="profileform-group">
                <label for="address">Lakcím</label>
                <input type="text" name="address" id="address" value="<?= htmlspecialchars($user['LAKCIM']) ?>">
            </div>
    
            <div class="profileform-group">
                <label for="password">Jelszó</label>
                <input type="password" name="password" id="password" placeholder="Új jelszó">
            </div>
    
            <div class="profileform-group">
                <label for="member">Törzsvásárló</label>
                <input type="text" name="member" id="member" value="<?= $user['TORZSVASARLO'] == 'Y' ? 'Igen' : 'Nem' ?>" readonly>
            </div>
        </div>
    
        <button type="submit">Mentés</button>
    </form>

</body>
</html>
