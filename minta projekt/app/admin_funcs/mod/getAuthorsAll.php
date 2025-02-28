<?php

//include "scripts/connectDB.php";

$sql = '
    DECLARE
        szerzo_cursor SYS_REFCURSOR;
    BEGIN
        OPEN szerzo_cursor FOR
            SELECT sz.id as id, sz.nev as nev
            FROM szerzo sz;

        :cursor := szerzo_cursor;
    END;
';

$stmt = oci_parse($conn, $sql);

$cursor = oci_new_cursor($conn);
oci_bind_by_name($stmt, ':cursor', $cursor, -1, OCI_B_CURSOR);

oci_execute($stmt);
oci_execute($cursor);

?>
