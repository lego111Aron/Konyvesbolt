<?php

//include "scripts/connectDB.php";

$sql = '
    DECLARE
        kiado_cursor SYS_REFCURSOR;
    BEGIN
        OPEN kiado_cursor FOR
            SELECT k.id as id, k.kiado_nev as nev
            FROM kiado k;

        :cursor := kiado_cursor;
    END;
';

$stmt = oci_parse($conn, $sql);

$cursor = oci_new_cursor($conn);
oci_bind_by_name($stmt, ':cursor', $cursor, -1, OCI_B_CURSOR);

oci_execute($stmt);
oci_execute($cursor);

?>
