<?php
include "../connect.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $nev = $_POST['mufaj_nev'];
    $mindenjo=true;

    if (empty($id) || empty($nev)) {
        echo "Hiba: Minden mezőt ki kell tölteni.";
    } else {

        $sql = "SELECT COUNT(*) AS count FROM mufaj WHERE id = :id";
        $stmt = oci_parse($conn, $sql);
        oci_bind_by_name($stmt, ":id", $id);
        oci_execute($stmt);
        $row = oci_fetch_assoc($stmt);
        $count = $row['COUNT'];
        
        if ($count == 0) {
            echo "Hiba: A megadott ID nem létezik a mufaj táblában.";
            $mindenjo=false;
        }
        $sql = "SELECT COUNT(*) AS count FROM mufaj WHERE mufaj_nev = :nev AND id != :id";
        $stmt = oci_parse($conn, $sql);
        oci_bind_by_name($stmt, ":nev", $nev);
        oci_bind_by_name($stmt, ":id", $id);
        oci_execute($stmt);
        $row = oci_fetch_assoc($stmt);
        $count = $row['COUNT'];

        if ($count > 0) {
            echo "Hiba: A megadott műfaj név már létezik.";
            $mindenjo=false;
        }

        if($mindenjo){
            $sql = "UPDATE mufaj SET mufaj_nev = :nev WHERE id = :id";
            $stmt = oci_parse($conn, $sql);
            oci_bind_by_name($stmt, ":nev", $nev);
            oci_bind_by_name($stmt, ":id", $id);
            oci_execute($stmt);
    
            header("Location:../../Front-end/admin.php");
        }else{
            echo "<a href='../../Front-end/admin.php'>Vissza az előző oldalra</a>";
        }

       
    }
}