<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book25</title>
    <link rel="stylesheet" href="StyleSheets/style.css">
    <link rel="stylesheet" href="StyleSheets/bestseller_style.css">
</head>

<body id="indexBody">

    <!--Fejléc és a menü-->
    <?php include "header.php"; ?>

    <h2><a href="profile.php">Profil info szerkesztése oldal</a></h2>
    <h1>Admin Funkciók:</h1>
    <h2><a href="admin.php">Műfajok + áruházak kezelése</a></h2>
    <h2><a href="bookregister.php">Könyvek + kiadók kezelése</a></h2>
    
    <h2><a href="../Back-end/authentication/logout.php">Kijelentkezés</a></h2>
    <h2><a href="../Back-end/authentication/delete_user.php" onclick="return confirm('Biztosan törölni szeretné a fiókját?')">Fiók törlése</a></h2>
    <h1>Legtöbbet eladott könyveink</h1><br>
    <div id="bestsellers-container">
      
        <?php
        
            include "../Back-end/connect.php";
            $bestSellers = [];
            $query = "SELECT konyv.ISBN, konyv.CIM, konyv.AR, SUM(vasarol.darab) AS total
                      FROM konyv 
                      JOIN vasarol ON konyv.ISBN = vasarol.ISBN
                      GROUP BY konyv.ISBN, konyv.CIM, konyv.AR
                      ORDER BY total DESC
                      FETCH FIRST 5 ROWS ONLY";
            $stmt = oci_parse($conn, $query);
            oci_execute($stmt);
            //folytatsd a kódot innen fetch_objekt-el
            while ($row = oci_fetch_object($stmt)) {
                $bestSellers[] = [
                    'isbn' => $row->ISBN,
                    'title' => $row->CIM,
                    'price' => $row->AR,
                    'total' => $row->TOTAL,
                ];
            }
            oci_free_statement($stmt);
        ?>
        <?php foreach ($bestSellers as $book): ?>
            <div class="book-row">
                <img src="../Back-end/img/<?php echo htmlspecialchars($book['isbn']); ?>.jpg" alt="Könyv borító">
                <span class="book-title"><?php echo htmlspecialchars($book['title']); ?></span>
                <span class="book-price"><?php echo number_format($book['price'], 0, ',', ' '); ?> Ft</span>
            </div>
        <?php endforeach; ?>
        

    </div>

</body>
</html>