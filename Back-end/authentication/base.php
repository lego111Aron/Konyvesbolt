<?php
    function fetchUsers(bool $toPrint = false) {
        include __DIR__ . "/../connect.php";

        $query = "SELECT * FROM FELHASZNALO";
        $stid = oci_parse($conn, $query);
        oci_execute($stid);

        $results = [];
        if ($stid) {
            $id = 0;
            while ($row = oci_fetch_assoc($stid)) {
                $results[] = [
                    "Username" => $row["FELHASZNALONEV"],
                    "Email" => $row["EMAIL"],
                    "Name" => $row["NEV"],
                    "Role" => $row["SZEREPKOR"],
                    "Address" => $row["LAKCIM"],
                    "Telephone" => $row["TELEFON"],
                    "Password" => $row["JELSZO"],
                    "Member" => $row["TORZSVASARLO"]
                ];

                if ($toPrint) {
                    echo 
                        "<br>----------------<br>" . 
                        "Number (not included in the database): " . $id . "<br>" .
                        "Username: " . $row["FELHASZNALONEV"] . "<br>" .
                        "Email: " . $row["EMAIL"] . "<br>" .
                        "Name: " . $row["NEV"] . "<br>" .
                        "Role: " . $row["SZEREPKOR"] . "<br>" .
                        "Address: " . $row["LAKCIM"] . "<br>" .
                        "Telephone number: " . $row["TELEFON"] . "<br>" .
                        "Password: " . $row["JELSZO"] . "<br>" .
                        "Member: " . $row["TORZSVASARLO"] . "<br>";
                }

                $id++;
            }
        }

        oci_free_statement($stid);
        oci_close($conn);

        return $results;
    }

    function sessionTest(bool $toPrint=false, bool $maintainSession=true) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (isset($_SESSION["username"])) {
            if ($toPrint) {
                if ($toPrint) echo "<br>----------------<br>";
                echo "Bejelentkezett felhasználó: " . $_SESSION["username"];
                if ($toPrint) echo "<br>----------------<br>";
            }
            
            if (!$maintainSession) {
                session_unset();
                session_destroy();
            }
            return true;
        } else {
            if ($toPrint) {
                if ($toPrint) echo "<br>----------------<br>";
                echo "Nincs bejelentkezett felhasznalo";
                if ($toPrint) echo "<br>----------------<br>";
            }

            if (!$maintainSession) {
                session_unset();
                session_destroy();
            }            
            return false;
        }
    }

    function isAdmin(bool $maintainSession=true) : bool {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $result = (isset($_SESSION["admin"]) && $_SESSION["admin"] === true);
        if (!$maintainSession) {
            session_unset();
            session_destroy();
        }

        return $result;
    }

    function printAllSessionData() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        echo "<br>----------------<br>";
        echo "Session Data:<br>";
        foreach ($_SESSION as $key => $value) {
            if (is_array($value)) {
                echo $key . ": " . json_encode($value) . "<br>";
            } else {
                echo $key . ": " . $value . "<br>";
            }
        }
        echo "----------------<br>";
    }
?>