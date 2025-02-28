<?php
include_once "scripts/connectDB.php";

/*$sql = '
    DECLARE
        aruhaz_cursor SYS_REFCURSOR;
    BEGIN
        OPEN aruhaz_cursor FOR
            SELECT aruhaz_id, a.cim AS aruhaz_cim, konyv_id, mennyiseg
            FROM keszlet k
            LEFT JOIN aruhaz a ON k.aruhaz_id = a.id
            WHERE konyv_id = :item_id;

        :cursor := aruhaz_cursor;
    END;
';*/


$sql = '
    BEGIN
        :cursor := get_item_stock(:item_id, :cursor);
    END;
';

$stmt = oci_parse($conn, $sql);

$cursor = oci_new_cursor($conn);
oci_bind_by_name($stmt, ':cursor', $cursor, -1, OCI_B_CURSOR);
oci_bind_by_name($stmt, ':item_id', $item_id);

oci_execute($stmt);
oci_execute($cursor);


?>