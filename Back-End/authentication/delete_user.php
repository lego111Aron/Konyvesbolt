<?php
    session_start();
    include "../connect.php";

    if (isset($_SESSION["username"])) {
        $username = $_SESSION["username"];

        $query = "DELETE FROM FELHASZNALO WHERE FELHASZNALONEV = :username";
        $stid = oci_parse($conn, $query);

        oci_bind_by_name($stid, ":username", $username);

        if (oci_execute($stid)) {
            session_unset();
            session_destroy();

            header("Location: ../../Front-end/login.html");
            exit;
        } else {
            $error = oci_error($stid);
            echo "<script>alert('Hiba történt a felhasználó törlése közben: " . htmlspecialchars($error['message']) . "'); history.back();</script>";
        }

        oci_free_statement($stid);
    } else {
        header("Location: ../../Front-end/login.html");
        exit;
    }

    oci_close($conn);
?>