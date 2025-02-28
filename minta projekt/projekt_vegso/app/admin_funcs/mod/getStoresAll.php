<?php

//include "scripts/connectDB.php";

$sql = '
    DECLARE
        aruhaz_cursor SYS_REFCURSOR;
    BEGIN
        OPEN aruhaz_cursor FOR
            SELECT a.id as id, a.cim as cim
            FROM aruhaz a;

        :cursor := aruhaz_cursor;
    END;
';

$stmt = oci_parse($conn, $sql);

$cursor = oci_new_cursor($conn);
oci_bind_by_name($stmt, ':cursor', $cursor, -1, OCI_B_CURSOR);

oci_execute($stmt);
oci_execute($cursor);

?>
