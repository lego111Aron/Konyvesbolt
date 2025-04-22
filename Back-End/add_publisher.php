<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $adoszam = $_POST['ADOSZAM'] ?? null;
    $nev = $_POST['NEV'] ?? null;
    $szekhely = $_POST['SZEKHELY'] ?? null;

    if (!$adoszam || !$nev || !$szekhely) {
        die("Minden mező kitöltése kötelező!");
    }

    include 'connect.php';

    $sql = "INSERT INTO kiado (adoszam, nev, szekhely) VALUES (:adoszam, :kiado_nev, :szekhely)";
    $stmt = oci_parse($conn, $sql);

    oci_bind_by_name($stmt, ":adoszam", $adoszam);
    oci_bind_by_name($stmt, ":kiado_nev", $nev);
    oci_bind_by_name($stmt, ":szekhely", $szekhely);

    if (oci_execute($stmt)) {
        echo "Kiadó sikeresen hozzáadva!";
    } else {
        $e = oci_error($stmt);
        echo "Hiba történt: " . $e['message'];
    }

    oci_free_statement($stmt);
    oci_close($conn);
    header("Location: ../Front-end/");

}
?>
