<?php

include "../connect.php";


if($_SERVER["REQUEST_METHOD"] === "POST"){
    $cim = substr(trim($_POST["CIM"] ?? ''), 0, 255);
    $email = substr(trim($_POST["EMAIL"] ?? ''), 0, 320);
    $telefon = substr(trim($_POST["TELEFON"] ?? ''), 0, 20);
    $vezeto = substr(trim($_POST["VEZETO"] ?? ''), 0, 50);


    // felhasználónév ellenőrzése a FELHASZNALO táblában
    $checkQuery = "SELECT FELHASZNALONEV FROM FELHASZNALO WHERE FELHASZNALONEV = :vezeto";
    $stidCheck = oci_parse($conn, $checkQuery);
    oci_bind_by_name($stidCheck, ":vezeto", $vezeto);

    oci_execute($stidCheck);

    // van-e ilyen felhasznalonev
    $userExists = oci_fetch_assoc($stidCheck);

    if($userExists){

        // Létezik ilyen, felhasználó szerepkör változtatása

        $updateRoleQuery = "UPDATE FELHASZNALO SET SZEREPKOR = 'uzletvezeto' WHERE FELHASZNALONEV = :vezeto";
        $stidUpdate = oci_parse($conn, $updateRoleQuery);
        oci_bind_by_name($stidUpdate, ":vezeto", $vezeto);
        oci_execute($stidUpdate);

        // Elmentjük az adatot


        $query = "INSERT INTO ARUHAZ (CIM, EMAIL, TELEFON, FELHASZNALO)
        VALUES (:cim, :email, :telefon, :vezeto)";

        $stid = oci_parse($conn, $query);

        oci_bind_by_name($stid, ":cim", $cim);
        oci_bind_by_name($stid, ":email", $email);
        oci_bind_by_name($stid, ":telefon", $telefon);
        oci_bind_by_name($stid, ":vezeto", $vezeto);



        if(oci_execute($stid)) {
            header("Location: ../../Front-end/index.php");
            exit;
        }else{
            $error = oci_error($stid);
            echo "<script>alert('Hiba történt: " . htmlspecialchars($error['message']) . "'); history.back();</script>";
        }

        oci_free_statement($stid);

    }else{
        // nem talalható ilyen felhasznalonev
        echo "<script>alert('A megadott felhasználónév nem létezik!'); history.back();</script>";
    }


}

oci_close($conn);

?>