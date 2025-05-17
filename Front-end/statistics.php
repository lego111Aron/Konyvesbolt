<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="StyleSheets/style.css">
    <link rel="stylesheet" href="StyleSheets/statistics_style.css">
    <title>Statisztikák</title>
    <?php
        include "../Back-end/connect.php";
        $array = array();
        $query= "SELECT mufaj.mufaj_nev, SUM(vasarol.darab) as eladas
                FROM mufaj
                JOIN konyv on konyv.id=mufaj.id
                JOIN vasarol on vasarol.ISBN=konyv.ISBN
                GROUP BY mufaj.mufaj_nev
                ORDER BY eladas DESC
                FETCH FIRST 3 ROWS ONLY";
        $stmt = oci_parse($conn, $query);
        oci_execute($stmt);
        while ($row = oci_fetch_object($stmt)) {
            $array[] =$row;
        }
        oci_free_statement($stmt);

        $szerzos=array();
        $query= "SELECT szerzo.nev, COUNT(szerez.ISBN) as konyvek_szama
                FROM szerzo
                JOIN szerez on szerez.id=szerzo.id
                GROUP BY szerzo.id, szerzo.nev
                ORDER BY konyvek_szama DESC
                FETCH FIRST 3 ROWS ONLY";
        $stmt = oci_parse($conn, $query);
        oci_execute($stmt);
        while ($row = oci_fetch_object($stmt)) {
            $szerzos[] =$row;
        }
        oci_free_statement($stmt);

        $LegolcsobbMufajonkent = array();
        $query="SELECT m.MUFAJ_NEV, k.CIM, k.AR
                FROM KONYV k
                JOIN MUFAJ m ON k.ID = m.ID
                WHERE (m.ID, k.AR) IN (
                    SELECT k2.ID, MIN(k2.AR)
                    FROM KONYV k2
                    GROUP BY k2.ID
                    )
                ORDER BY m.MUFAJ_NEV";
        $stmt = oci_parse($conn, $query);
        oci_execute($stmt);
        while ($row = oci_fetch_object($stmt)) {
            $LegolcsobbMufajonkent[] =$row;
        }
        oci_free_statement($stmt);

        $kiados=array();
        $query="SELECT ki.NEV AS KIADO_NEV, COUNT(k.ISBN) AS KONYVEK_SZAMA, ROUND(AVG(k.AR), 0) AS ATLAG_AR
                FROM KONYV k
                JOIN KIADO ki ON k.ADOSZAM = ki.ADOSZAM
                GROUP BY ki.NEV
                ORDER BY KONYVEK_SZAMA DESC";
        $stmt = oci_parse($conn, $query);
        oci_execute($stmt);
        while ($row = oci_fetch_object($stmt)) {
            $kiados[] =$row;
        }
        oci_free_statement($stmt);

        $legtobbOldal=array();
        $query="SELECT sz.NEV, SUM(k.OLDALAK_SZAMA) AS OSSZ_OLDAL
                FROM SZERZO sz
                JOIN SZEREZ szr ON sz.ID = szr.ID
                JOIN KONYV k ON szr.ISBN = k.ISBN
                GROUP BY sz.NEV
                ORDER BY OSSZ_OLDAL DESC
                FETCH FIRST 3 ROWS ONLY";

        $stmt = oci_parse($conn, $query);
        oci_execute($stmt);
        while ($row = oci_fetch_object($stmt)) {
            $legtobbOldal[] =$row;
        }
        oci_free_statement($stmt);

        $aruhazas=array();
        $query="SELECT a.CIM AS CIM, SUM(v.KESZLET) AS OSSZES_KESZLET
                FROM ARUHAZ a
                JOIN VAN v ON a.ID = v.ID
                GROUP BY a.CIM
                ORDER BY OSSZES_KESZLET DESC
                FETCH FIRST 3 ROWS ONLY";
        $stmt = oci_parse($conn, $query);
        oci_execute($stmt);
        while ($row = oci_fetch_object($stmt)) {
            $aruhazas[] =$row;
        }
        oci_free_statement($stmt);



        /*echo"<pre>";
        echo"<br>";
        print_r($szerzos);
        echo"</pre>";*/
     ?>
</head>
<body>
    <?php include "header.php"; ?>
    <div class="card">
        <h2>Legkeresettebb műfajok:</h2>
        <ol>
            <?php
                foreach ($array as $item) {
                    echo "<li class='placement'>" . $item->MUFAJ_NEV. "</li>";
                }
            ?>
        </ol>
    </div>
    <div class="card">
        <h2>A legtöbb elérhető könyvet jegyző szerző</h2>
        <ol>
            <?php
                foreach ($szerzos as $item) {
                    echo "<li class='placement'>" . $item->NEV." - ".$item->KONYVEK_SZAMA ."</li>";
                }
            ?>
        </ol>
    </div>
    <div class="card">
        <h2>Legolcsóbb könyvek műfajonként:</h2>
        <table>
            <tr>
                <th>Műfaj</th>
                <th>Könyv</th>
                <th>Ár</th>
            </tr>
            <?php
            foreach ($LegolcsobbMufajonkent as $item) {
                echo "<tr>";
                echo "<td>" . $item->MUFAJ_NEV . "</td>";
                echo "<td>" . $item->CIM . "</td>";
                echo "<td>" . number_format($item->AR, 0, ',', ' ') . " Ft</td>";
                echo "</tr>";
            }
            ?>
        </table>
    </div>
    <div class="card">
        <h2>Átlagárak és kínálat mérete kiadónként:</h2>
        <table>
            <tr>
                <th>Kiadó</th>
                <th>Könyvek száma</th>
                <th>Átlag ár</th>
            </tr>
            <?php
            foreach ($kiados as $item) {
                echo "<tr>";
                echo "<td>" . $item->KIADO_NEV . "</td>";
                echo "<td>" . $item->KONYVEK_SZAMA . "</td>";
                echo "<td>" . number_format($item->ATLAG_AR, 0, ',', ' ') . " Ft</td>";
                echo "</tr>";
            }
            ?>
        </table>
    </div>
    <div class="card">
        <h2>Top 3 legtöbb oldalt író szerző:</h2>
        <ol>
            <?php
                foreach ($legtobbOldal as $item) {
                    echo "<li class='placement'>" . $item->NEV." - ".$item->OSSZ_OLDAL ." oldal</li>";
                }
            ?>
        </ol>
    </div>
    <div class="card">
        <h2>Top 3 legnagyobb készlettel rendelkező áruházunk:</h2>
        <ol>
            <?php
                foreach ($aruhazas as $item) {
                    echo "<li class='placement'>" . $item->CIM." - ".$item->OSSZES_KESZLET ." db</li>";
                }
            ?>
        </ol>

    </div>
</body>
</html>