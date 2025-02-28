<?php
include "../../scripts/connectDB.php";

$store = $_POST["store"];
$book = $_POST["book"];
$amount = $_POST["amount"];

$sql = '
    DECLARE
        v_count INTEGER;
        v_quantity INTEGER;
    BEGIN
        v_count := 0;

        SELECT COUNT(*) INTO v_count
        FROM keszlet
        WHERE aruhaz_id = :aruhaz AND konyv_id = :konyv;

        IF v_count = 0 THEN
            INSERT INTO keszlet (aruhaz_id, konyv_id, mennyiseg) 
            VALUES (:aruhaz, :konyv, :mennyiseg);
        ELSE
            SELECT mennyiseg INTO v_quantity
            FROM keszlet
            WHERE aruhaz_id = :aruhaz AND konyv_id = :konyv;

            UPDATE keszlet
            SET mennyiseg = v_quantity + :mennyiseg
            WHERE aruhaz_id = :aruhaz AND konyv_id = :konyv;
        END IF;
    END;   
';

$stid = oci_parse($conn, $sql);
if (!$stid) {
    $m = oci_error($conn);
    trigger_error(htmlentities($m['message']), E_USER_ERROR);
}

oci_bind_by_name($stid, ':aruhaz', $store);
oci_bind_by_name($stid, ':konyv', $book);
oci_bind_by_name($stid, ':mennyiseg', $amount);

$r = oci_execute($stid);
if (!$r) {
    $m = oci_error($stid);
    trigger_error(htmlentities($m['message']), E_USER_ERROR);
}

echo "Record added successfully.";

oci_free_statement($stid);
oci_close($conn);

header("Location: ../../index.php?page=admin");