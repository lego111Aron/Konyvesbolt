<?php
include "connect.php";

if (isset($_GET['isbn']) && !empty($_GET['isbn'])) {
    $isbn = $_GET['isbn'];
    $mindenjo=true;

    $sql = "DELETE FROM KONYV WHERE ISBN = :isbn";
    $stmt = oci_parse($conn, $sql);
    oci_bind_by_name($stmt, ":isbn", $isbn);

    if (oci_execute($stmt)) {
        header("Location: ../front-end/bookregister.php");
        exit;
    } else {
        echo "Hiba történt a törlés során.";
        $mindenjo=false;
    }
} else {
    echo "Nincs megadva ISBN a törléshez.";
    $mindenjo=false;
}

if(!$mindenjo){
    echo "<br><a href='../Front-end/bookregister.php'>Vissza az előző oldalra</a>";
}
?>
