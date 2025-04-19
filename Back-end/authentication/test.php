<?php
    function fetchUsers(bool $toPrint = false) {
        include "../connect.php";

        $query = "SELECT * FROM FELHASZNALO";
        $stid = oci_parse($conn, $query);  // A lekérdezés előkészítése
        oci_execute($stid);  // A lekérdezés végrehajtása

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

        // Kapcsolat bezárása
        oci_free_statement($stid);
        oci_close($conn);

        return $results;
    }

    // echo "<pre>";
    // print_r(fetchUsers());
    // echo "</pre>";
    // fetchUsers(true);
?>