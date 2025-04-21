<?php

$tns = "
(DESCRIPTION =
    (ADDRESS_LIST =
        (ADDRESS = (PROTOCOL = TCP)(HOST = localhost)(PORT = 1521))
    )
    (CONNECT_DATA =
        (SID = orania2)
    )
)";
$conn = oci_connect('C##O4005C', 'Adatbalapu123', $tns, 'UTF8');

if (!$conn) {
    $error_message = oci_error();
    echo "<span class='text-danger'>Csatlakozás sikertelen: " . $error_message['message'] . "</span>";
    exit;
} else {
    echo "<span class='text-success'>Sikeres csatlakozás!</span><br/>";
    echo "Oracle Database verzió: <span style='font-family: Consolas !important;'>" . oci_server_version($conn) . "</span>";
}

?>