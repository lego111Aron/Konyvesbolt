<?php

include "../../scripts/connectDB.php";

$sql = '
    DECLARE
        mufaj_cursor SYS_REFCURSOR;
    BEGIN
        OPEN mufaj_cursor FOR
            SELECT m.id as id, m.mufaj_nev as nev, m.almufaj_nev as almufaj_nev
            FROM mufaj m;

        :cursor := mufaj_cursor;
    END;
';

$stmt = oci_parse($conn, $sql);

$genre_cursor = oci_new_cursor($conn);
oci_bind_by_name($stmt, ':cursor', $genre_cursor, -1, OCI_B_CURSOR);

oci_execute($stmt);
oci_execute($genre_cursor);

?>