<?php
include "scripts/connectDB.php";

if (!$conn) {
    $error_message = oci_error();
    echo "<span class='text-danger'>Csatlakozás sikertelen: " . $error_message['message'] . "</span>";
    exit;
} else {
    echo "<span class='text-success'>Sikeres csatlakozás!</span><br/>";
    echo "Oracle Database verzió: <span style='font-family: Consolas !important;'>" . oci_server_version($conn) . "</span>";
}

?>