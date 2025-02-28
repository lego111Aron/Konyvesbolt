<?php
session_start(); // Munkamenet folytatása

// Ellenőrizzük, hogy az 'id' és a 'user_id' mezők megérkeztek-e a POST kérésből
if (isset($_POST['id'], $_SESSION['user_id'])) {
    include_once "connectDB.php"; // Adatbázis kapcsolódás

    // Vásárlás törlése az adatbázisból
    $purchase_id = $_POST['id'];
    $user_id = $_SESSION['user_id'];

    // SQL lekérdezés a vásárlás törlésére
    $sql = "DELETE FROM VASARLAS WHERE ID = :purchase_id AND FELHASZNALO_ID = :user_id";

    $stmt = oci_parse($conn, $sql);
    oci_bind_by_name($stmt, ':purchase_id', $purchase_id);
    oci_bind_by_name($stmt, ':user_id', $user_id);

    $success = oci_execute($stmt);

    if ($success) {
        header("Location: ../?page=myPurchases");
        exit();
    } else {
        echo "Hiba történt a törlés közben";
    }

    oci_free_statement($stmt);
    oci_close($conn);
} else {
    header("Location: ../?page=myPurchases");
    exit();
}
?>
