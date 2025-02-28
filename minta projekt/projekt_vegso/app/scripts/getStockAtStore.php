<?php

$aruhaz_id = $_GET['id'];

$sql = '
    SELECT
        a.aruhaz_cim,
        konyv.id AS konyv_id,
        konyv.cim AS konyv_cim,
        k.mennyiseg
    FROM keszlet k
    LEFT JOIN (SELECT id, cim AS aruhaz_cim FROM aruhaz
    ) a ON a.id = k.aruhaz_id
    LEFT JOIN konyv ON konyv.id = k.konyv_id
    WHERE aruhaz_id = :aruhaz_id
';


$stmt = oci_parse($conn, $sql);

oci_bind_by_name($stmt, ':aruhaz_id', $aruhaz_id);

oci_execute($stmt);


$sqlAruhaz = '
    SELECT cim FROM aruhaz where id = :aruhaz_id
';

$stmtAruhaz = oci_parse($conn, $sqlAruhaz);
oci_bind_by_name($stmtAruhaz, ':aruhaz_id', $aruhaz_id);
oci_execute($stmtAruhaz);
$aruhaz_cim_valasztott = oci_fetch_assoc($stmtAruhaz);

?>