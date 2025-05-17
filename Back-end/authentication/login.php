<?php
    session_start(); // Session indítása
    include "../connect.php";

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $email = trim($_POST["EMAIL"] ?? '');
        $password = trim($_POST["JELSZO"] ?? '');

/*         if (empty($email) || empty($password)) {
            echo "<script>alert('Hiányzó adatok!'); history.back();</script>";
            exit;
        } */

        $query = "SELECT FELHASZNALONEV, JELSZO FROM FELHASZNALO WHERE EMAIL = :email";
        $stid = oci_parse($conn, $query);

        oci_bind_by_name($stid, ":email", $email);
        oci_execute($stid);


        $user = oci_fetch_assoc($stid);
        if ($user && password_verify($password, $user["JELSZO"])) {

            $_SESSION["username"] = $user["FELHASZNALONEV"];
            $_SESSION["email"] = $email;
            if ($user["FELHASZNALONEV"] == "admin")
                $_SESSION["admin"] = true;
            else
                $_SESSION["admin"] = false;

            header("Location: ../../Front-end/index.php");
            exit;
        } else {
            echo "<script>alert('Hibás bejelentkezési adatok!'); history.back();</script>";
            exit;
        }

        oci_free_statement($stid);
    }

    oci_close($conn);
?>