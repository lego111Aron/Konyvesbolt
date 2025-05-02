<?php
function fetchBooks(bool $toPrint = false, array $filter = []) {
    include __DIR__ . "/../connect.php"; // Helyes útvonal meghatározása

    // Dinamikus WHERE feltételek építése
    $whereClauses = [];
    $binds = [];

    if (!empty($filter["search"])) {
        $whereClauses[] = "LOWER(CIM) LIKE :search";
        $binds[":search"] = "%" . strtolower($filter["search"]) . "%";
    }

    if (!empty($filter["price"]) && is_array($filter["price"]) && count($filter["price"]) == 2) {
        $whereClauses[] = "AR BETWEEN :minPrice AND :maxPrice";
        $binds[":minPrice"] = $filter["price"][0];
        $binds[":maxPrice"] = $filter["price"][1];
    }

    $whereSql = "";
    if (!empty($whereClauses)) {
        $whereSql = " WHERE " . implode(" AND ", $whereClauses);
    }

    // Könyvek számának lekérdezése
    $countQuery = "SELECT COUNT(*) AS BOOK_COUNT FROM KONYV" . $whereSql;
    $countStmt = oci_parse($conn, $countQuery);
    foreach ($binds as $key => $val) {
        oci_bind_by_name($countStmt, $key, $binds[$key]);
    }
    oci_execute($countStmt);
    $row = oci_fetch_assoc($countStmt);
    $bookCount = $row["BOOK_COUNT"];
    oci_free_statement($countStmt);

    if ($toPrint) {
        echo "<br>----------------<br>";
        echo "Szűrő szerinti könyvek száma: " . $bookCount . "<br>";
        echo "<br>----------------<br>";
    }

    // Könyvek lekérdezése
    $query = "SELECT * FROM KONYV" . $whereSql;
    $stid = oci_parse($conn, $query);
    foreach ($binds as $key => $val) {
        oci_bind_by_name($stid, $key, $binds[$key]);
    }
    oci_execute($stid);

    $results = [];
    $id = 0;
    while ($row = oci_fetch_assoc($stid)) {
        $results[] = [
            "ISBN" => $row["ISBN"],
            "PublicationDate" => $row["KIADAS"],
            "Title" => $row["CIM"],
            "Pages" => $row["OLDALAK_SZAMA"],
            "Price" => $row["AR"],
            "TaxNumber" => $row["ADOSZAM"],
            "ID" => $row["ID"]
        ];

        if ($toPrint) {
            echo 
                "<br>----------------<br>" .
                "Book number: " . $id . "<br>" .
                "ISBN: " . $row["ISBN"] . "<br>" .
                "Publication date: " . $row["KIADAS"] . "<br>" .
                "Title: " . $row["CIM"] . "<br>" .
                "Pages: " . $row["OLDALAK_SZAMA"] . "<br>" .
                "Price: " . $row["AR"] . "<br>" .
                "Tax number: " . $row["ADOSZAM"] . "<br>" .
                "ID: " . $row["ID"] . "<br>";
        }

        $id++;
    }

    oci_free_statement($stid);
    oci_close($conn);

    return $results;
}

function fetchGenres(bool $toPrint = false) {
    include __DIR__ . "/../connect.php"; // Helyes útvonal meghatározása

    $query = "SELECT * FROM MUFAJ ORDER BY MUFAJ_NEV";
    $stid = oci_parse($conn, $query);
    oci_execute($stid);

    $results = [];
    $id = 0;

    while ($row = oci_fetch_assoc($stid)) {
        $results[] = [
            "ID" => $row["ID"],
            "GenreName" => $row["MUFAJ_NEV"]
        ];

        if ($toPrint) {
            echo 
                "<br>----------------<br>" .
                "Genre number: " . $id . "<br>" .
                "ID: " . $row["ID"] . "<br>" .
                "Genre name: " . $row["MUFAJ_NEV"] . "<br>";
        }

        $id++;
    }

    oci_free_statement($stid);
    oci_close($conn);

    return $results;
}
?>