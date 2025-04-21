<?php 
    include "connect.php";

    $query = "SELECT * FROM FELHASZNALO";
    $stid = oci_parse($conn, $query);
    oci_execute($stid);

    while ($row = oci_fetch_assoc($stid)) {
        echo $row['FELHASZNALONEV'] . " - " . $row['SZEREPKOR'] . "<br>";
    }

    oci_free_statement($stid);
    oci_close($conn);
?>