<?php
require_once '../Back-end/connect.php'; // Oracle kapcsolódás

$query = "SELECT NEV, SZEKHELY  FROM KIADO"; // SQL lekérdezés
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

<body id="authorsBody">

    <!--Fejléc és a menü-->
    <?php include "header.php"; ?>

    <div class="store-container">
            <h1>Kiadók</h1>

        <?php while ($row = oci_fetch_assoc($stid)): ?>
            <div class="store">
                <img src="./StyleSheets/author-temp-image.png" alt="bolt ikon">
                <div class="store-info">
                    <strong><?= htmlspecialchars($row['NEV']) ?></strong>
                    <div class = "store-adatok">
                        <span>Székhely:<?= htmlspecialchars($row['SZEKHELY']) ?></span>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>


</body>
</html>