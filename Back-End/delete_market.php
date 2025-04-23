<?php
include "connect.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $mindenjo = true;

    if (!is_numeric($id)) {
        echo "Hiba: Érvénytelen ID.";
        $mindenjo = false;
    }

    $sql = "SELECT felhasznalo FROM aruhaz WHERE id = :id";
    $stmt = oci_parse($conn, $sql);
    oci_bind_by_name($stmt, ":id", $id);
    oci_execute($stmt);
    $row = oci_fetch_assoc($stmt);

    if (!$row) {
        echo "Hiba: Nincs ilyen ID-jű áruház.";
        $mindenjo = false;
    } else {
        $felhasznalo = $row['FELHASZNALO'];
        $sql = "DELETE FROM aruhaz WHERE id = :id";
        $stmt = oci_parse($conn, $sql);
        oci_bind_by_name($stmt, ":id", $id);
        if (!oci_execute($stmt)) {
            echo "Hiba az áruház törlése során.";
            $mindenjo = false;
        }
        if ($mindenjo) {
            $sql = "UPDATE felhasznalo SET szerepkor = 'felhasznalo' WHERE felhasznalonev = :felhasznalo";
            $stmt = oci_parse($conn, $sql);
            oci_bind_by_name($stmt, ":felhasznalo", $felhasznalo);
            if (!oci_execute($stmt)) {
                echo "Hiba a szerepkör visszaállítása során.";
                $mindenjo = false;
            }
        }
    }

    if ($mindenjo) {
        header("Location: ../Front-end/admin.php");
        exit;
    } 
} else {
    echo "Hiányzó ID paraméter.";
    $mindenjo = false;
}
if(!$mindenjo) {
    echo "<br><a href='../Front-end/admin.php'>Vissza az admin oldalra</a>";
}
?>
