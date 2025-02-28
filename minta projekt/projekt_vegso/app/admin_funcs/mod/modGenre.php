<?php
include "../../scripts/connectDB.php";

if ($_POST["submit"] == "del"){
    $id = $_POST["id"];

    $sql = 'DELETE FROM mufaj
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
$genre_name = $_POST["genre_name"];
$subgenre_name = $_POST["subgenre_name"];

$sql = 'UPDATE mufaj
SET mufaj_nev = :genre_name, almufaj_nev = :subgenre_name
WHERE id = :id';

$stid = oci_parse($conn, $sql);
if (!$stid) {
    $m = oci_error($conn);
    trigger_error(htmlentities($m['message']), E_USER_ERROR);
}

oci_bind_by_name($stid, ':genre_name', $genre_name);
oci_bind_by_name($stid, ':subgenre_name', $subgenre_name);
oci_bind_by_name($stid, ':id', $id);

$r = oci_execute($stid);
if (!$r) {
    $m = oci_error($stid);
    trigger_error(htmlentities($m['message']), E_USER_ERROR);
}

echo "Record updated successfully.";

oci_free_statement($stid);
oci_close($conn);

header("Location: ../../index.php?page=admin");