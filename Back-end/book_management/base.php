<?php
function fetchBooks(bool $toPrint = false, array $filter = []) {
    include __DIR__ . "/../connect.php";

    $search = !empty($filter["search"]) ? $filter["search"] : null;
    $minPrice = 0;
    $maxPrice = 999999;
    $genres = !empty($filter["genres"]) ? $filter["genres"] : [];

    if (!empty($filter["price"]) && is_array($filter["price"]) && count($filter["price"]) == 2) {
        $minPrice = $filter["price"][0];
        $maxPrice = $filter["price"][1];
    }

    // STR_ARRAY típus használata
    $genreArray = oci_new_collection($conn, 'STR_ARRAY');
    if (!$genreArray) {
        die("Nem sikerült létrehozni a STR_ARRAY típusú collection-t.");
    }

    foreach ($genres as $genre) {
        $genreArray->append(strtolower($genre));
    }

    $stid = oci_parse($conn, "BEGIN FETCH_FILTERED_BOOKS(:search, :min_price, :max_price, :genres, :result); END;");

    oci_bind_by_name($stid, ":search", $search);
    oci_bind_by_name($stid, ":min_price", $minPrice);
    oci_bind_by_name($stid, ":max_price", $maxPrice);
    oci_bind_by_name($stid, ":genres", $genreArray, -1, OCI_B_NTY);

    $cursor = oci_new_cursor($conn);
    oci_bind_by_name($stid, ":result", $cursor, -1, OCI_B_CURSOR);

    oci_execute($stid);
    oci_execute($cursor);

    $results = [];
    $id = 0;
    while ($row = oci_fetch_assoc($cursor)) {
        $results[] = [
            "ISBN" => $row["ISBN"],
            "PublicationDate" => $row["KIADAS"],
            "Title" => $row["CIM"],
            "Pages" => $row["OLDALAK_SZAMA"],
            "Price" => $row["AR"],
            "TaxNumber" => $row["ADOSZAM"],
            "ID" => $row["ID"]
            // FIXME: hozza kell adni a műfajt is
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
    oci_free_statement($cursor);
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