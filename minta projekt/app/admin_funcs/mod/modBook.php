<?php
include "../../scripts/connectDB.php";

if ($_POST["submit"] == "del"){
    $id = $_POST["id"];

    $sql = 'DELETE FROM konyv
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
$title = $_POST["title"];
$author = $_POST["author"];
$publisher = $_POST["publisher"];
$page_count = $_POST["page_count"];
$desc = $_POST["desc"];
$lang = $_POST["lang"];
$genre = $_POST["genre"];
$price = $_POST["price"];

$sql = 'UPDATE konyv
SET cim = :title, szerzo_id = :author, kiado_id = :publisher, oldalszam = :page_count, leiras = :descr, nyelv = :lang,  mufaj_id = :genre, ar = :price
WHERE id = :id';

$stid = oci_parse($conn, $sql);
if (!$stid) {
    $m = oci_error($conn);
    trigger_error(htmlentities($m['message']), E_USER_ERROR);
}

oci_bind_by_name($stid, ':id', $id);
oci_bind_by_name($stid, ':title', $title);
oci_bind_by_name($stid, ':author', $author);
oci_bind_by_name($stid, ':publisher', $publisher);
oci_bind_by_name($stid, ':page_count', $page_count);
oci_bind_by_name($stid, ':descr', $desc);
oci_bind_by_name($stid, ':lang', $lang);
oci_bind_by_name($stid, ':genre', $genre);
oci_bind_by_name($stid, ':price', $price);

$r = oci_execute($stid);
if (!$r) {
    $m = oci_error($stid);
    trigger_error(htmlentities($m['message']), E_USER_ERROR);
}

echo "Record updated successfully.";

oci_free_statement($stid);
oci_close($conn);

header("Location: ../../index.php?page=admin");