<?php
include "base.php";
include "../authentication/base.php";

printAllSessionData();

// Például így lehet meghívni kiíratással:
fetchGenres(true);

// Teszteléshez kiírjuk
$filter = [
    // "search" => "teszt", // Keresett szöveg a könyv címében
    // "price" => [0, 4000] // Ár tartomány
];

fetchBooks(true, $filter);
?>