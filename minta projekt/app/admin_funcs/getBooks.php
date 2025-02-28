<?php

//include "../../scripts/connectDB.php";

$sql = '
    DECLARE
        konyv_cursor SYS_REFCURSOR;
    BEGIN
        OPEN konyv_cursor FOR
            SELECT k.id as id, k.cim as cim
            FROM konyv k;

        :cursor := konyv_cursor;
    END;
';

$stmt = oci_parse($conn, $sql);

$book_cursor = oci_new_cursor($conn);
oci_bind_by_name($stmt, ':cursor', $book_cursor, -1, OCI_B_CURSOR);

oci_execute($stmt);
oci_execute($book_cursor);

?>