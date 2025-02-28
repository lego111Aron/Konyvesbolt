<?php
include "../../scripts/connectDB.php";

$title = $_POST["title"];
$author = $_POST["author"];
$publisher = $_POST["publisher"];
$page_count = $_POST["page_count"];
$desc = $_POST["desc"];
$lang = $_POST["lang"];
$genre = $_POST["genre"];
$price = $_POST["price"];

$sql = '
    DECLARE
        v_max_id konyv.id%TYPE;
    BEGIN
        SELECT id INTO v_max_id
        FROM konyv
        WHERE id = (SELECT MAX(id) FROM konyv);

        :max_id := v_max_id;
    END;
';

$stmt = oci_parse($conn, $sql);

oci_bind_by_name($stmt, ':max_id', $max_id);

oci_execute($stmt);

$id = $max_id + 1;

$sql = 'INSERT INTO konyv (id, cim, szerzo_id, kiado_id, oldalszam, leiras, nyelv, mufaj_id, ar) 
VALUES (:id, :title, :author, :publisher, :page_count, :descr, :lang, :genre, :price)';

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

echo "Record added successfully.";

oci_free_statement($stid);
oci_close($conn);

header("Location: ../../index.php?page=admin");