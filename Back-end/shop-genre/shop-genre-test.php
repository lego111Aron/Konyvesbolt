<?php
include "../connect.php";

$query = "SELECT MUFAJ_NEV FROM MUFAJ";
$stid = oci_parse($conn, $query);
oci_execute($stid);

echo "<h2>Műfajok listája:</h2>";
echo "<ul>";

while ($row = oci_fetch_assoc($stid)) {
    echo "<li>" . htmlspecialchars($row['MUFAJ_NEV']) . "</li>";
}

echo "</ul>";

oci_free_statement($stid);
oci_close($conn);
?>