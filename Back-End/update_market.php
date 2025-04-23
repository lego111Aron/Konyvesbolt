<?php
include "connect.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = $_POST['id'] ?? '';
    $cim = $_POST['cim'] ?? '';
    $telefon = $_POST['telefon'] ?? '';
    $email = $_POST['email'] ?? '';
    $felhasznalo = $_POST['felhasznalo'] ?? '';
    $mindenjo = true;

    if (!empty($id) && !empty($cim) && !empty($telefon) && !empty($email) && !empty($felhasznalo)) {
        $sql = "SELECT felhasznalo FROM aruhaz WHERE id = :id";
        $stmt = oci_parse($conn, $sql);
        oci_bind_by_name($stmt, ":id", $id);
        oci_execute($stmt);
        $row = oci_fetch_assoc($stmt);

        if (!$row) {
            echo "Hiba: A megadott ID nem létezik az aruhaz táblában.";
            $mindenjo = false;
        } else {
            $regi_felhasznalo = $row['FELHASZNALO'];
            if ($regi_felhasznalo !== $felhasznalo) {
                $sql = "SELECT COUNT(*) AS count FROM felhasznalo WHERE felhasznalonev = :felhasznalo";
                $stmt = oci_parse($conn, $sql);
                oci_bind_by_name($stmt, ":felhasznalo", $felhasznalo);
                oci_execute($stmt);
                $row = oci_fetch_assoc($stmt);
                $count = $row['COUNT'];

                if ($count == 0) {
                    echo "Hiba: A megadott üzletvezető nem létezik.";
                    $mindenjo = false;
                }
                else{
                    $sql = "SELECT COUNT(*) AS count FROM aruhaz WHERE felhasznalo = :felhasznalo";
                    $stmt = oci_parse($conn, $sql);
                    oci_bind_by_name($stmt, ":felhasznalo", $felhasznalo);
                    oci_execute($stmt);
                    $row = oci_fetch_assoc($stmt);
                    $count = $row['COUNT'];

                    if ($count > 0) {
                        echo "Hiba: A megadott üzletvezető már foglalt.";
                        $mindenjo = false;
                    }else{
                        $sql = "UPDATE felhasznalo SET szerepkor = 'felhasznalo' WHERE felhasznalonev = :felhasznalo";
                        $stmt = oci_parse($conn, $sql);
                        oci_bind_by_name($stmt, ":felhasznalo", $regi_felhasznalo);
                        if (!oci_execute($stmt)) {
                            echo "Hiba: Nem sikerült visszaállítani a régi üzletvezető szerepkörét.";
                            $mindenjo = false;
                        }
                        $sql = "UPDATE felhasznalo SET szerepkor = 'uzletvezeto' WHERE felhasznalonev = :felhasznalo";
                        $stmt = oci_parse($conn, $sql);
                        oci_bind_by_name($stmt, ":felhasznalo", $felhasznalo);
                        if (!oci_execute($stmt)) {
                            echo "Hiba: Nem sikerült az új üzletvezető szerepkörét beállítani.";
                            $mindenjo = false;
                        }
                    }
                }   
            }
            if($mindenjo){
                $sql = "UPDATE aruhaz 
                    SET cim = :cim, telefon = :telefon, email = :email, felhasznalo = :felhasznalo 
                    WHERE id = :id";

                $stmt = oci_parse($conn, $sql);
                oci_bind_by_name($stmt, ":cim", $cim);
                oci_bind_by_name($stmt, ":telefon", $telefon);
                oci_bind_by_name($stmt, ":email", $email);
                oci_bind_by_name($stmt, ":felhasznalo", $felhasznalo);
                oci_bind_by_name($stmt, ":id", $id);

                if (oci_execute($stmt)) {
                    header("Location: ../Front-end/admin.php");
                    exit;
                } else {
                    echo "Hiba a frissítés során.";
                    $mindenjo = false;
                }
            }

        }

            
    } else {
        echo "Minden mezőt ki kell tölteni!";
        $mindenjo = false;
    }
} else {
    echo "Érvénytelen kérés.";
    $mindenjo = false;
}

if (!$mindenjo) {
    echo "<br><a href='../Front-end/admin.php'>Vissza az előző oldalra</a>";
}
?>
