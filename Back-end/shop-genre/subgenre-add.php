<?php

include "../connect.php";


if($_SERVER["REQUEST_METHOD"] === "POST"){
    $almufaj_nev = substr(trim($_POST["ALMUFAJ_NEV"] ?? ''), 0, 50);

    if(!empty($almufaj_nev)){

        // van e már ilyen műfaj, kis és nagybetűt figyelembe véve

        $checkQuery = "SELECT ALMUFAJ_NEV FROM ALMUFAJ WHERE LOWER(ALMUFAJ_NEV) = LOWER(:almufaj_nev)";
        $stidCheck = oci_parse($conn, $checkQuery);
        oci_bind_by_name($stidCheck, ":almufaj_nev", $almufaj_nev);
        oci_execute($stidCheck);

        if(oci_fetch($stidCheck)){
            echo "<script>alert('Ez az alműfaj már létezik az adatbázisban!'); history.back();</script>";
            oci_free_statement($stidCheck);

        }else{

            oci_free_statement($stidCheck);

            // beszúrás

            $insertQuery = "INSERT INTO ALMUFAJ (ALMUFAJ_NEV)
                            VALUES (:almufaj_nev)";
            $stidInsert = oci_parse($conn, $insertQuery);
            oci_bind_by_name($stidInsert, ":almufaj_nev", $almufaj_nev);

            if(oci_execute($stidInsert)){
                echo "<script>alert('Sikeres alműfajhozzáadás!'); window.location.href='../../Front-end/index.html';</script>";

            }else{
                $error = oci_error($stidInsert);
                echo "<script>alert('Hiba történt: " . htmlspecialchars($error['message']) . "'); history.back();</script>";
            }

            oci_free_statement($stidInsert);
            
        }

    }else {
        echo "<script>alert('Az alműfaj név megadása kötelező!'); history.back();</script>";
    }

}

oci_close($conn);

?>