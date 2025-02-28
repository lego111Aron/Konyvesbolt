<?php

//include "scripts/connectDB.php";

$sql = '
    DECLARE
        keszlet_cursor SYS_REFCURSOR;
    BEGIN
        OPEN keszlet_cursor FOR
            SELECT a.id as aruhaz_id, kv.id as konyv_id, k.mennyiseg
            FROM keszlet k
            LEFT JOIN aruhaz a ON a.id = k.aruhaz_id
            LEFT JOIN konyv kv ON kv.id = k.konyv_id;

        :cursor := keszlet_cursor;
    END;
';

$stmt = oci_parse($conn, $sql);

$cursor = oci_new_cursor($conn);
oci_bind_by_name($stmt, ':cursor', $cursor, -1, OCI_B_CURSOR);

oci_execute($stmt);
oci_execute($cursor);

?>
