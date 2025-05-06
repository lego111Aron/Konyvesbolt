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
        //fetch object-el kiolvasni a konyveket
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
        //fetch object-el kiolvasni a konyveket
        while ($row = oci_fetch_object($stmt)) {
            $szerzos[] =$row;
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
</body>
</html>