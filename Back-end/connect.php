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
// FIXME: visszaalltani az eredetire

$conn = oci_connect('C##O4005C', 'Adatbalapu123', $tns, 'UTF8');

if (!$conn) {
    $error_message = oci_error();
    echo "<span class='text-danger'>Csatlakozás sikertelen: " . $error_message['message'] . "</span>";
    exit;
}

?>