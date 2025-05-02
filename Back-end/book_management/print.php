<?php
include "base.php";

// Például így lehet meghívni kiíratással:
fetchGenres(true);

// Teszteléshez kiírjuk
$filter = [
    "search" => "teszt", // Keresett szöveg a könyv címében
    "price" => [2000, 4000] // Ár tartomány
];

fetchBooks(true);
?>