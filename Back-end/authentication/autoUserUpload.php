<?php
include "../connect.php";
include "base.php";

if (!$conn) {
    $e = oci_error();
    die("Sikertelen kapcsolódás: " . $e['message']);
}

// CSV fájlok elérési útja
$users_csv = "people-100.csv";
$addresses_csv = "address-sample.csv";

// Hány felhasználót regisztráljunk (paraméterként adható meg URL-ben pl.: import_users.php?count=10)
// $limit = isset($_GET['count']) ? intval($_GET['count']) : 10;
$limit = 50;

// Felhasználók betöltése
$users = array_map('str_getcsv', file($users_csv));
$addresses = array_map('str_getcsv', file($addresses_csv));

// Fejléc eltávolítása
array_shift($users);
array_shift($addresses);

// Ellenőrzés: van-e elég adat?
if (count($users) < $limit || count($addresses) < $limit) {
    die("Nincs elég adat a fájlokban.");
}

// Telefonszám kezdőérték
$telefon_base = 6700000001;

for ($i = 0; $i < $limit; $i++) {
    $user = $users[$i];
    $address = $addresses[$i];

    // CSV oszlopok alapján (feltételezve fix sorrendet)
    $keresztnev = trim($user[2]);
    $vezeteknev = trim($user[3]);
    $email = trim($user[5]);

    $varos = trim($address[11]);
    $cim = trim($address[5]); // street

    // Regisztrációhoz szükséges adatok
    $felhasznalonev = $keresztnev;
    $nev = $vezeteknev . " " . $keresztnev;
    $lakcim = $varos . ", " . $cim;
    $telefon = "0" . $telefon_base++;

    $jelszo_hashed = password_hash($felhasznalonev, PASSWORD_DEFAULT);

    // Ellenőrzés: felhasználónév és email létezik-e
    $ellenorzes_stmt = oci_parse($conn, "BEGIN ELLENORIZ_REGISZTRACIO(:fnev, :email, :felh_letezik, :email_letezik); END;");
    oci_bind_by_name($ellenorzes_stmt, ":fnev", $felhasznalonev);
    oci_bind_by_name($ellenorzes_stmt, ":email", $email);
    oci_bind_by_name($ellenorzes_stmt, ":felh_letezik", $felh_letezik, 1);
    oci_bind_by_name($ellenorzes_stmt, ":email_letezik", $email_letezik, 1);
    oci_execute($ellenorzes_stmt);
    oci_free_statement($ellenorzes_stmt);

    if ($felh_letezik == 1 || $email_letezik == 1) {
        echo "SKIP: {$felhasznalonev} / {$email} már létezik.<br>";
        continue;
    }

    // Regisztráció
    $stmt = oci_parse($conn, "BEGIN REGISZTRAL_FELHASZNALO(:fnev, :email, :nev, :lakcim, :tel, :jelszo); END;");
    oci_bind_by_name($stmt, ":fnev", $felhasznalonev);
    oci_bind_by_name($stmt, ":email", $email);
    oci_bind_by_name($stmt, ":nev", $nev);
    oci_bind_by_name($stmt, ":lakcim", $lakcim);
    oci_bind_by_name($stmt, ":tel", $telefon);
    oci_bind_by_name($stmt, ":jelszo", $jelszo_hashed);

    $result = oci_execute($stmt);

    if ($result) {
        echo "Sikeres regisztráció: $felhasznalonev ($email)<br>";
    } else {
        $e = oci_error($stmt);
        echo "Hiba történt: " . $e['message'] . "<br>";
    }

    oci_free_statement($stmt);
}

oci_close($conn);
?>
