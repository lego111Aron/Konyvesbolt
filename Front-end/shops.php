<?php
require_once '../Back-end/connect.php'; // Oracle kapcsolódás

$query = "SELECT CIM, EMAIL, TELEFON  FROM ARUHAZ"; // SQL lekérdezés
$stid = oci_parse($conn, $query);  // Lekérdezés előkészítése
oci_execute($stid);                // Lekérdezés végrehajtása
?>


<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book25</title>
    <link rel="stylesheet" href="StyleSheets/style.css">
</head>

<body id="shopsBody">

    <!--Fejléc-->
    <div class="topbar">
        <div class="logo"><a href="index.php">BOOK<span>25</span>.hu</a></div>
        <div class="login"><a href="login.php">Bejelentkezés</a></div>
    </div>

    <!--Menü-->
    <div class="navbar">
        <a href="index.php">Főoldal</a>
        <a href="books.php">Könyvek</a>
        <a href="authors.php">Kiadók</a>
        <a href="shops.php">Áruházak</a>
        <a href="basket.php">Kosár</a>
        <a href="#">Statisztikák</a>
    </div>

    <div class="store-container">
            <h1>ÁRUHÁZAINK</h1>

        <?php while ($row = oci_fetch_assoc($stid)): ?>
            <div class="store">
                <img src="./StyleSheets/storeicon.png" alt="bolt ikon">
                <div class="store-info">
                    <strong><?= htmlspecialchars($row['CIM']) ?></strong>
                    <div class = "store-adatok">
                        <span>Email: <a href="mailto:<?= htmlspecialchars($row['EMAIL']) ?>"><?= htmlspecialchars($row['EMAIL']) ?></a></span>
                        <span>Telefon: <?= htmlspecialchars($row['TELEFON']) ?></span>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>


    
</body>
</html>