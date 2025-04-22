<?php

include "../connect.php";

            // ALMŰFAJ TEST

/*

$query = "SELECT ALMUFAJ_NEV FROM ALMUFAJ";
$stid = oci_parse($conn, $query);
oci_execute($stid);

echo "<h2>Alműfajok listája:</h2>";
echo "<ul>";

while ($row = oci_fetch_assoc($stid)) {
    echo "<li>" . htmlspecialchars($row['ALMUFAJ_NEV']) . "</li>";
}

echo "</ul>";

oci_free_statement($stid);
oci_close($conn);


            // MŰFAJ TEST


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

*/

            // ARUHAZ TESTS

$query = "SELECT CIM, EMAIL, TELEFON, FELHASZNALO FROM ARUHAZ";
$stid = oci_parse($conn, $query);
oci_execute($stid);

echo "<h2>Áruházak listája</h2>";
echo "<table border='1' cellpadding='5'>
        <tr><th>Cím</th><th>Email</th><th>Telefon</th><th>Vezető</th></tr>";

while ($row = oci_fetch_assoc($stid)) {
    echo "<tr>
            <td>" . htmlspecialchars($row['CIM']) . "</td>
            <td>" . htmlspecialchars($row['EMAIL']) . "</td>
            <td>" . htmlspecialchars($row['TELEFON']) . "</td>
            <td>" . htmlspecialchars($row['FELHASZNALO']) . "</td>
          </tr>";
}

echo "</table>";

oci_free_statement($stid);
oci_close($conn);


?>

