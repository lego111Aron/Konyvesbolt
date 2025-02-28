<?php
include "../../scripts/connectDB.php";

if ($_POST["submit"] == "del"){
    $id = $_POST["id"];

    $sql = 'DELETE FROM kiado
    WHERE id = :id';

    $stid = oci_parse($conn, $sql);
    if (!$stid) {
        $m = oci_error($conn);
        trigger_error(htmlentities($m['message']), E_USER_ERROR);
    }

    oci_bind_by_name($stid, ':id', $id);

    $r = oci_execute($stid);
    if (!$r) {
        $m = oci_error($stid);
        trigger_error(htmlentities($m['message']), E_USER_ERROR);
    }

    echo "Record deleted successfully.";

    oci_free_statement($stid);
    oci_close($conn);

    header("Location: ../../index.php?page=admin");
}

$id = $_POST["id"];
$name = $_POST["name"];

$sql = 'UPDATE kiado
SET kiado_nev = :name
WHERE id = :id';

$stid = oci_parse($conn, $sql);
if (!$stid) {
    $m = oci_error($conn);
    trigger_error(htmlentities($m['message']), E_USER_ERROR);
}

oci_bind_by_name($stid, ':id', $id);
oci_bind_by_name($stid, ':name', $name);

$r = oci_execute($stid);
if (!$r) {
    $m = oci_error($stid);
    trigger_error(htmlentities($m['message']), E_USER_ERROR);
}

echo "Record updated successfully.";

oci_free_statement($stid);
oci_close($conn);

header("Location: ../../index.php?page=admin");