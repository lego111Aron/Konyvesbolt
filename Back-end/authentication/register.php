<?php
include "../connect.php";
include "base.php";

if (!$conn) {
    $e = oci_error();
    die("Sikertelen kapcsolódás: " . $e['message']);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $felhasznalonev = $_POST['FELHASZNALONEV'];
    $email = $_POST['EMAIL'];
    $nev = $_POST['NEV'];
    $lakcim = $_POST['LAKCIM'];
    $telefon = $_POST['TELEFON'];
    $jelszo = $_POST['JELSZO'];
    $jelszo_ujra = $_POST['JELSZO_UJRA'];

    if ($jelszo !== $jelszo_ujra) {
        echo "<script>alert('A két jelszó nem egyezik meg!'); history.back();</script>";
        exit;
    }

    $jelszo_hashed = password_hash($jelszo, PASSWORD_DEFAULT);

    $ellenorzes_stmt = oci_parse($conn, "BEGIN ELLENORIZ_REGISZTRACIO(:fnev, :email, :felh_letezik, :email_letezik); END;");
    oci_bind_by_name($ellenorzes_stmt, ":fnev", $felhasznalonev);
    oci_bind_by_name($ellenorzes_stmt, ":email", $email);
    oci_bind_by_name($ellenorzes_stmt, ":felh_letezik", $felh_letezik, 1);
    oci_bind_by_name($ellenorzes_stmt, ":email_letezik", $email_letezik, 1);

    oci_execute($ellenorzes_stmt);
    oci_free_statement($ellenorzes_stmt);

    if ($felh_letezik == 1 || $email_letezik == 1) {
        $hiba = "";
        if ($felh_letezik == 1) {
            $hiba .= "A megadott felhasználónév már létezik. ";
        }
        if ($email_letezik == 1) {
            $hiba .= "A megadott email-cím már létezik.";
        }
        echo "<script>alert('$hiba'); history.back();</script>";
        oci_close($conn);
        exit;
    }

    $stmt = oci_parse($conn, "BEGIN REGISZTRAL_FELHASZNALO(:fnev, :email, :nev, :lakcim, :tel, :jelszo); END;");
    oci_bind_by_name($stmt, ":fnev", $felhasznalonev);
    oci_bind_by_name($stmt, ":email", $email);
    oci_bind_by_name($stmt, ":nev", $nev);
    oci_bind_by_name($stmt, ":lakcim", $lakcim);
    oci_bind_by_name($stmt, ":tel", $telefon);
    oci_bind_by_name($stmt, ":jelszo", $jelszo_hashed);

    $result = oci_execute($stmt);

    if ($result) {
        header("Location: ../../Front-end/login.php");
        exit;
    } else {
        $e = oci_error($stmt);
        echo "Hiba történt: " . $e['message'];
    }

    oci_free_statement($stmt);
    oci_close($conn);
}
?>