<?php
include __DIR__ . "/base.php";

if (!sessionTest()) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION["username"];

$newEmail = $_POST['email'];
$newPhone = $_POST['phone'];
$newAddress = $_POST['address'];
$newPassword = $_POST['password']; // opcionális

include __DIR__ . "/../connect.php";

// Jelenlegi adatok lekérése
$query = "SELECT * FROM FELHASZNALO WHERE FELHASZNALONEV = :username";
$stmt = oci_parse($conn, $query);
oci_bind_by_name($stmt, ":username", $username);
oci_execute($stmt);
$currentUser = oci_fetch_assoc($stmt);

// Email ellenőrzés
if ($newEmail !== $currentUser['EMAIL']) {
    $checkEmailQuery = "SELECT COUNT(*) AS CNT FROM FELHASZNALO WHERE EMAIL = :email AND FELHASZNALONEV != :username";
    $checkStmt = oci_parse($conn, $checkEmailQuery);
    oci_bind_by_name($checkStmt, ":email", $newEmail);
    oci_bind_by_name($checkStmt, ":username", $username);
    oci_execute($checkStmt);
    $result = oci_fetch_assoc($checkStmt);

    if ($result['CNT'] > 0) {
        echo "<script>alert('A megadott email-cím már használatban van!'); history.back();</script>";
        oci_free_statement($stmt);
        oci_free_statement($checkStmt);
        oci_close($conn);
        exit;
    }

    oci_free_statement($checkStmt);
}

// Változások ellenőrzése
$changes = false;
$updatePassword = false;

if ($newEmail !== $currentUser['EMAIL']) $changes = true;
if ($newPhone !== $currentUser['TELEFON']) $changes = true;
if ($newAddress !== $currentUser['LAKCIM']) $changes = true;
if (!empty($newPassword)) {
    $changes = true;
    $updatePassword = true;
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
}

if ($changes) {
    if ($updatePassword) {
        $updateQuery = "UPDATE FELHASZNALO 
                        SET EMAIL = :email, TELEFON = :phone, LAKCIM = :address, JELSZO = :password
                        WHERE FELHASZNALONEV = :username";

        $updateStmt = oci_parse($conn, $updateQuery);
        oci_bind_by_name($updateStmt, ":password", $hashedPassword);
    } else {
        $updateQuery = "UPDATE FELHASZNALO 
                        SET EMAIL = :email, TELEFON = :phone, LAKCIM = :address
                        WHERE FELHASZNALONEV = :username";

        $updateStmt = oci_parse($conn, $updateQuery);
    }

    oci_bind_by_name($updateStmt, ":email", $newEmail);
    oci_bind_by_name($updateStmt, ":phone", $newPhone);
    oci_bind_by_name($updateStmt, ":address", $newAddress);
    oci_bind_by_name($updateStmt, ":username", $username);
    oci_execute($updateStmt);

    echo "<script>alert('A profiladatok sikeresen frissítve lettek.'); window.location.href = '../../Front-end/profile.php';</script>";
} else {
    echo "<script>alert('Nincs változtatás a profiladatokban.'); window.location.href = '../../Front-end/profile.php';</script>";
}

oci_free_statement($stmt);
if (isset($updateStmt)) oci_free_statement($updateStmt);
oci_close($conn);
?>
