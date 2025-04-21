<?php 
    include "connect.php";

    $query="SELECT * FROM ARUHAZ";
    $stid = oci_parse($conn, $query);  // A lekérdezés előkészítése
    oci_execute($stid);  // A lekérdezés végrehajtása

    // Eredmények kiíratása
    while ($row = oci_fetch_assoc($stid)) {
        echo $row['CIM'] . "<br>";  // Az eredményeket a megfelelő oszlopokkal kiírni
    }

    // Kapcsolat bezárása
    oci_free_statement($stid);
    oci_close($conn);
?>