<?php
        session_start();

     //nézzük meg, hogy volt e post
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $username = $_SESSION["username"];
            include "../connect.php";

            //bolt azonosítója
            $query = "SELECT id FROM aruhaz WHERE felhasznalo = :felhasznalo_nev";
            $stid = oci_parse($conn, $query);
            oci_bind_by_name($stid, ':felhasznalo_nev', $username);
            oci_execute($stid);
            $row = oci_fetch_object($stid);
            $bolt_id = $row->ID;
            oci_free_statement($stid);

            $isbn=$_POST['isbn'] ?? '';
            $keszlet=$_POST['keszlet'] ?? '';

            $query = "SELECT COUNT(*) AS count FROM van WHERE id = :bolt_id AND isbn = :isbn";
            $stid = oci_parse($conn, $query);
            oci_bind_by_name($stid, ':bolt_id', $bolt_id);
            oci_bind_by_name($stid, ':isbn', $isbn);
            oci_execute($stid);
            $row = oci_fetch_object($stid);
            $count = $row->COUNT;
            oci_free_statement($stid);
            if($count == 0){
                $query = "INSERT INTO van (id, isbn, keszlet) VALUES (:bolt_id, :isbn, :keszlet)";
                $stid = oci_parse($conn, $query);
                oci_bind_by_name($stid, ':bolt_id', $bolt_id);
                oci_bind_by_name($stid, ':isbn', $isbn);
                oci_bind_by_name($stid, ':keszlet', $keszlet);
                oci_execute($stid);
                oci_free_statement($stid);
                //header("Location: ../../Front-end/stock.php"); // Irányítjuk a stock.php oldalra");
            }else if($count == 1){
                $query = "UPDATE van SET keszlet = :keszlet WHERE id = :bolt_id AND isbn = :isbn";
                $stid = oci_parse($conn, $query);
                oci_bind_by_name($stid, ':bolt_id', $bolt_id);
                oci_bind_by_name($stid, ':isbn', $isbn);
                oci_bind_by_name($stid, ':keszlet', $keszlet);
                oci_execute($stid);
                oci_free_statement($stid);
                //header("Location: ../../Front-end/stock.php");
                
            }else{
                echo "Hiba: Túl sok sor található a van táblában az adott boltban és könyv isbn számával.";
                echo "<a href='../../Front-end/stock.php'>Vissza a raktárhoz</a>";
                oci_free_statement($stid);
            }
        }else{
            //header("Location: ../../Front-end/ "); // Ha nem POST kérés, irányítjuk az index oldalra
        }

?>