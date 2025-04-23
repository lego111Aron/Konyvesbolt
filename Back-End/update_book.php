<?php
include "connect.php";

// Csak POST kéréseket kezelünk
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $isbn = $_POST['isbn'] ?? '';
    $cim = $_POST['cim'] ?? '';
    $oldalak_szama = $_POST['oldalak_szama'] ?? '';
    $ar = $_POST['ar'] ?? '';
    $mindenjo=true;


    if (!empty($isbn) && !empty($cim) && !empty($oldalak_szama) && !empty($ar)) {
        //Ellenőrozzük, hogy az ár naem negatív-e
        if($ar<0 || $oldalak_szama<0){
            echo "Hiba: Az ár és az oldalszám nem lehet negatív.";
            $mindenjo=false;
        }
        if($mindenjo){

        
        // Ellenőrizzük, hogy az ISBN szám létezik-e
        $sql = "SELECT COUNT(*) AS count FROM KONYV WHERE ISBN = :isbn";
        $stmt = oci_parse($conn, $sql);
        oci_bind_by_name($stmt, ":isbn", $isbn);
        oci_execute($stmt);
        $row = oci_fetch_assoc($stmt);
        $count = $row['COUNT'];
        if ($count == 0) {
            echo "Hiba: A megadott ISBN szám nem létezik a KONYV táblában.";
            $mindenjo=false;
        }else{
            $sql = "UPDATE KONYV SET CIM = :cim, OLDALAK_SZAMA = :oldalak_szama, AR = :ar WHERE ISBN = :isbn";
            $stmt = oci_parse($conn, $sql);

            oci_bind_by_name($stmt, ":cim", $cim);
            oci_bind_by_name($stmt, ":oldalak_szama", $oldalak_szama);
            oci_bind_by_name($stmt, ":ar", $ar);
            oci_bind_by_name($stmt, ":isbn", $isbn);

            if (oci_execute($stmt)) {
                header("Location: ../Front-end/bookregister.php"); 
                exit();
            } else {
                echo "Hiba történt a frissítés során.";
                $mindenjo=false;
            }

        }
    }
    

        
    } else {
        echo "Minden mező kitöltése kötelező!";
        $mindenjo=false;
    }
} else {
    echo "Érvénytelen kérés.";
    $mindenjo=false;
}
if(!$mindenjo){
    echo "<br><a href='../Front-end/bookregister.php'>Vissza az előző oldalra</a>";
}
?>
