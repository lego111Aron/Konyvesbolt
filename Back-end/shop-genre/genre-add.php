<?php

include "../connect.php";


if($_SERVER["REQUEST_METHOD"] === "POST"){
    $mufaj_nev = substr(trim($_POST["MUFAJ_NEV"] ?? ''), 0, 50);

    if(!empty($mufaj_nev)){

        // van e már ilyen műfaj, kis és nagybetűt figyelembe véve

        $checkQuery = "SELECT MUFAJ_NEV FROM MUFAJ WHERE LOWER(MUFAJ_NEV) = LOWER(:mufaj_nev)";
        $stidCheck = oci_parse($conn, $checkQuery);
        oci_bind_by_name($stidCheck, ":mufaj_nev", $mufaj_nev);
        oci_execute($stidCheck);

        if(oci_fetch($stidCheck)){
            echo "<script>alert('Ez a műfaj már létezik az adatbázisban!'); history.back();</script>";
            oci_free_statement($stidCheck);

        }else{

            oci_free_statement($stidCheck);

            // beszúrás

            $insertQuery = "INSERT INTO MUFAJ (MUFAJ_NEV)
                            VALUES (:mufaj_nev)";
            $stidInsert = oci_parse($conn, $insertQuery);
            oci_bind_by_name($stidInsert, ":mufaj_nev", $mufaj_nev);

            if(oci_execute($stidInsert)){
                echo "<script>alert('Sikeres műfajhozzáadás!'); window.location.href='../../Front-end/index.html';</script>";

            }else{
                $error = oci_error($stidInsert);
                echo "<script>alert('Hiba történt: " . htmlspecialchars($error['message']) . "'); history.back();</script>";
            }

            oci_free_statement($stidInsert);
            
        }

    }else {
        echo "<script>alert('A műfaj név megadása kötelező!'); history.back();</script>";
    }

}

oci_close($conn);

?>