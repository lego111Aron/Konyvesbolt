<?php
    session_start(); // Session indítása
    include "../connect.php";

    // Ellenőrizzük, hogy van-e bejelentkezett felhasználó
    if (isset($_SESSION["username"])) {
        $username = $_SESSION["username"];

        // Felhasználó törlése az adatbázisból
        $query = "DELETE FROM FELHASZNALO WHERE FELHASZNALONEV = :username";
        $stid = oci_parse($conn, $query);

        // Paraméter bindolása
        oci_bind_by_name($stid, ":username", $username);

        // Lekérdezés végrehajtása
        if (oci_execute($stid)) {
            // Sikeres törlés esetén kijelentkeztetés
            session_unset();
            session_destroy();

            // Átirányítás az index.php oldalra
            header("Location: ../../Front-end/login.html");
            exit;
        } else {
            // Hiba esetén hibaüzenet megjelenítése
            $error = oci_error($stid);
            echo "<script>alert('Hiba történt a felhasználó törlése közben: " . htmlspecialchars($error['message']) . "'); history.back();</script>";
        }

        // Erőforrások felszabadítása
        oci_free_statement($stid);
    } else {
        // Ha nincs bejelentkezett felhasználó, átirányítás az index.php oldalra
        header("Location: ../../Front-end/login.html");
        exit;
    }

    // Kapcsolat lezárása
    oci_close($conn);
?>