<?php
    include "../connect.php";
    include "test.php";

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $name = substr(trim($_POST["NEV"] ?? ''), 0, 100);
        $email = substr(trim($_POST["EMAIL"] ?? ''), 0, 320);
        $username = substr(trim($_POST["FELHASZNALONEV"] ?? ''), 0, 50);
        $password = substr(trim($_POST["JELSZO"] ?? ''), 0, 100);
        $phone = substr(trim($_POST["TELEFON"] ?? ''), 0, 20);
        $address = substr(trim($_POST["LAKCIM"] ?? ''), 0, 255);
        $member = 'N';

        // Ellenőrzés: minden mező ki van töltve
/*         if (empty($name) || empty($email) || empty($username) || empty($password) || empty($phone) || empty($address)) {
            echo "<script>alert('Hiányzó adatok!'); history.back();</script>";
            exit;
        } */

        // Felhasználónév ellenőrzése
        $existingUsers = fetchUsers();
        foreach ($existingUsers as $user) {
            if (strcasecmp($user["Username"], $username) === 0) {
                echo "<script>alert('Ez a felhasználónév már foglalt!'); history.back();</script>";
                exit;
            }
            if (strcasecmp($user["Email"], $email) === 0) {
                echo "<script>alert('Ez az emailcím már regisztrálva van!'); history.back();</script>";
                exit;
            }
        }

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $query = "INSERT INTO FELHASZNALO (FELHASZNALONEV, EMAIL, NEV, SZEREPKOR, LAKCIM, TELEFON, JELSZO, TORZSVASARLO) 
                  VALUES (:username, :email, :name, 'felhasznalo', :address, :phone, :password, :member)";
        $stid = oci_parse($conn, $query);

        oci_bind_by_name($stid, ":name", $name);
        oci_bind_by_name($stid, ":email", $email);
        oci_bind_by_name($stid, ":username", $username);
        oci_bind_by_name($stid, ":password", $hashed_password);
        oci_bind_by_name($stid, ":phone", $phone);
        oci_bind_by_name($stid, ":address", $address);
        oci_bind_by_name($stid, ":member", $member);

        if (oci_execute($stid)) {
            header("Location: ../../Front-end/login.html");
            exit;
        } else {
            $error = oci_error($stid);
            echo "<script>alert('Hiba történt: " . htmlspecialchars($error['message']) . "'); history.back();</script>";
        }

        oci_free_statement($stid);
    }

    oci_close($conn);
?>
