<?php
include "../connect.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $mindenjo=true;


    if (!is_numeric($id)) {
        echo "Hiba: Érvénytelen ID.";
        $mindenjo=false;
    }else{
        $sql = "SELECT COUNT(*) AS count FROM almufaj WHERE id = :id";
        $stmt = oci_parse($conn, $sql);
        oci_bind_by_name($stmt, ":id", $id);
        oci_execute($stmt);
        $row = oci_fetch_assoc($stmt);
        $count = $row['COUNT'];
        if ($count == 0) {
            echo "Hiba: A megadott ID nem létezik az almufaj táblában.";
            $mindenjo=false;
        }else{
            $sql = "DELETE FROM almufaj WHERE id = :id";
            $stmt = oci_parse($conn, $sql);
            oci_bind_by_name($stmt, ":id", $id);
            oci_execute($stmt);
        }
    }

    if($mindenjo){
        header("Location:../../Front-end/admin.php");
    }else{
        echo "<br><a href='../../Front-end/admin.php'>Vissza az előző oldalra</a>";
    }
   
}
?>