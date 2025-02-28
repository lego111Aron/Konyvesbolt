<?php
include "../../scripts/connectDB.php";

$name = $_POST["name"];

$sql = '
    DECLARE
        v_max_id kiado.id%TYPE;
    BEGIN
        SELECT id INTO v_max_id
        FROM kiado
        WHERE id = (SELECT MAX(id) FROM kiado);

        :max_id := v_max_id;
    END;
';

$stmt = oci_parse($conn, $sql);

oci_bind_by_name($stmt, ':max_id', $max_id);

oci_execute($stmt);

$id = $max_id + 1;

$sql = 'INSERT INTO kiado (id, kiado_nev) 
VALUES (:id, :nev)';

$stid = oci_parse($conn, $sql);
if (!$stid) {
    $m = oci_error($conn);
    trigger_error(htmlentities($m['message']), E_USER_ERROR);
}

oci_bind_by_name($stid, ':id', $id);
oci_bind_by_name($stid, ':nev', $name);

$r = oci_execute($stid);
if (!$r) {
    $m = oci_error($stid);
    trigger_error(htmlentities($m['message']), E_USER_ERROR);
}

echo "Record added successfully.";

oci_free_statement($stid);
oci_close($conn);

header("Location: ../../index.php?page=admin");