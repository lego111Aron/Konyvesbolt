<?php 
    include "connect.php";

    $query="SELECT * FROM FELHASZNALO";
    $stid = oci_parse($conn, $query);  // A lekérdezés előkészítése
    oci_execute($stid);  // A lekérdezés végrehajtása

    // Eredmények kiíratása
    while ($row = oci_fetch_assoc($stid)) {
        echo $row['FELHASZNALONEV'] . "<br>";  // Az eredményeket a megfelelő oszlopokkal kiírni
    }

    // Kapcsolat bezárása
    oci_free_statement($stid);
    oci_close($conn);
?>