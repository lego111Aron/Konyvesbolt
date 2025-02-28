<?php

$sql_top = '
    DECLARE
        top_konyvek_cursor SYS_REFCURSOR;
    BEGIN
        OPEN top_konyvek_cursor FOR
            SELECT
                konyv_id,
                k.cim as konyv_cim,
                sz.nev as szerzo_nev,
                k.ar,
                vasarlas_cnt
            FROM (
                SELECT
                    KONYV_ID,
                    sum(mennyiseg) AS vasarlas_cnt
                FROM VASARLAS v
                GROUP BY KONYV_ID
                ORDER BY COUNT(*) DESC
                FETCH FIRST 5 ROWS ONLY
            ) top
            LEFT JOIN konyv k on k.id = top.konyv_id
            LEFT JOIN szerzo sz on sz.id = k.szerzo_id;
        
        :top_cursor := top_konyvek_cursor;
    END;
';

$stmt_top = oci_parse($conn, $sql_top);
$top_cursor = oci_new_cursor($conn);
oci_bind_by_name($stmt_top,':top_cursor', $top_cursor, -1, OCI_B_CURSOR);

oci_execute($stmt_top);
oci_execute($top_cursor);

?>