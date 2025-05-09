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

    <!--Fejléc és a menü-->
    <?php include "header.php"; ?>

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
                <input type="text" name="member" id="member" value="<?= $user['TORZSVASARLO'] == 'I' ? 'Igen' : 'Nem' ?>" readonly>
            </div>
        </div>

        <div class="profileform-button-container">
            <button type="submit" id="mentes">Mentés</button>
            <button type="button" id="kijelentkezes">Kijelentkezés</button>         
        </div>
        <p><a href="../Back-end/authentication/delete_user.php" onclick="return confirm('Biztosan törölni szeretné a fiókját?')">Fiók törlése</a></p>
    </form>

        <!-- Korábbi vásárlások -->

    <script>
        document.getElementById("kijelentkezes").addEventListener("click", () => {
            window.location.href = "../Back-End/authentication/logout.php";
        });
    </script>

</body>
</html>
