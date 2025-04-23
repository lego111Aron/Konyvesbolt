<?php
include "connect.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $adoszam = $_POST['adoszam'] ?? '';
    $nev = $_POST['nev'] ?? '';
    $szekhely = $_POST['szekhely'] ?? '';
    $mindenjo = true;

    if (!empty($adoszam) && !empty($nev) && !empty($szekhely)) {
        $sql = "UPDATE KIADO SET NEV = :nev, SZEKHELY = :szekhely  WHERE ADOSZAM = :adoszam";

        $stmt = oci_parse($conn, $sql);
        oci_bind_by_name($stmt, ":nev", $nev);
        oci_bind_by_name($stmt, ":szekhely", $szekhely);
        oci_bind_by_name($stmt, ":adoszam", $adoszam);

        if (oci_execute($stmt)) {
            header("Location: ../Front-end/bookregister.php"); // sikeres frissítés után vissza
            exit;
        } else {
            echo "Hiba történt a frissítés során.";
            $mindenjo = false;
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
    echo "<br><a href='../Front-end/bookregister.php'>Vissza az előző oldalra</a>";
}
?>
