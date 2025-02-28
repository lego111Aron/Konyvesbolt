<?php
include "../../scripts/connectDB.php";

if ($_POST["submit"] == "del"){
    $store_id = $_POST["store"];
    $book_id = $_POST["book"];

    $sql = 'DELETE FROM keszlet
    WHERE aruhaz_id = :store AND konyv_id = :book';

    $stid = oci_parse($conn, $sql);
    if (!$stid) {
        $m = oci_error($conn);
        trigger_error(htmlentities($m['message']), E_USER_ERROR);
    }

    oci_bind_by_name($stid, ':store', $store_id);
    oci_bind_by_name($stid, ':book', $book_id);

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

$store_id = $_POST["store"];
$book_id = $_POST["book"];
$amount = $_POST["amount"];

$sql = 'UPDATE keszlet
SET mennyiseg = :amount
WHERE aruhaz_id = :store AND konyv_id = :book';

$stid = oci_parse($conn, $sql);
if (!$stid) {
    $m = oci_error($conn);
    trigger_error(htmlentities($m['message']), E_USER_ERROR);
}

oci_bind_by_name($stid, ':store', $store_id);
oci_bind_by_name($stid, ':book', $book_id);
oci_bind_by_name($stid, ':amount', $amount);

$r = oci_execute($stid);
if (!$r) {
    $m = oci_error($stid);
    trigger_error(htmlentities($m['message']), E_USER_ERROR);
}

echo "Record updated successfully.";

oci_free_statement($stid);
oci_close($conn);

header("Location: ../../index.php?page=admin");