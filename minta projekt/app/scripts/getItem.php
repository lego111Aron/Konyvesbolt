<?php
include_once "scripts/connectDB.php";

$item_id = $_GET['id'];

$sql = '
    DECLARE
        TYPE konyv_rekord IS RECORD (
            id NUMBER,
            cim VARCHAR2(50),
            szerzo VARCHAR2(40),
            kiado_nev VARCHAR2(40),
            oldalszam NUMBER,
            leiras VARCHAR2(256),
            nyelv VARCHAR2(20),
            mufaj_nev VARCHAR2(40),
            almufaj_nev VARCHAR2(40),
            ar NUMBER,
            kifuto NUMBER
        );
        v_konyv konyv_rekord;
    BEGIN
        SELECT
            k.id,
            cim,
            sz.nev as szerzo,
            ki.kiado_nev,
            oldalszam,
            leiras,
            nyelv,
            m.kategoria,
            m.mufaj,
            k.ar,
            k.kifuto
            INTO v_konyv
        FROM konyv k
        LEFT JOIN szerzo sz ON sz.id = k.szerzo_id
        LEFT JOIN kiado ki ON ki.id = k.kiado_id
        LEFT JOIN (SELECT id, mufaj_nev AS kategoria, almufaj_nev as mufaj from mufaj) m ON m.id = k.mufaj_id
        WHERE k.id = :item_id;

        :cim := v_konyv.CIM;
        :szerzo := v_konyv.SZERZO;
        :kiado_nev := v_konyv.KIADO_NEV;
        :oldalszam := v_konyv.OLDALSZAM;
        :leiras := v_konyv.LEIRAS;
        :nyelv := v_konyv.NYELV;
        :mufaj_nev := v_konyv.MUFAJ_NEV;
        :almufaj_nev := v_konyv.ALMUFAJ_NEV;
        :ar := v_konyv.AR;
        :kifuto := v_konyv.KIFUTO;
    END;
';

$stmt = oci_parse($conn, $sql);

oci_bind_by_name($stmt, ':item_id', $item_id);

oci_bind_by_name($stmt, ':cim', $cim, 50);
oci_bind_by_name($stmt, ':szerzo', $szerzo, 40);
oci_bind_by_name($stmt, ':kiado_nev', $kiado_nev, 40);
oci_bind_by_name($stmt, ':oldalszam', $oldalszam, SQLT_INT);
oci_bind_by_name($stmt, ':leiras', $leiras, 256);
oci_bind_by_name($stmt, ':nyelv', $nyelv, 20);
oci_bind_by_name($stmt, ':mufaj_nev', $mufaj_nev, 40);
oci_bind_by_name($stmt, ':almufaj_nev', $almufaj_nev, 40);
oci_bind_by_name($stmt, ':ar', $ar, SQLT_INT);
oci_bind_by_name($stmt, ':kifuto', $kifuto, 1);


oci_execute($stmt);

?>
