<?php
session_start();
include "../connect.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = isset($_SESSION["username"]) ? $_SESSION["username"] : "vendeg";

    $address = trim($_POST["address"]);

    $cart = $_SESSION["cart"] ?? [];
    if (empty($cart)) {
        echo "<script>alert('A kosár üres.'); window.location.href='../../Front-end/basket.php';</script>";
        exit();
    }

    $isbnList = array_keys($cart);
    $placeholders = [];
    foreach ($isbnList as $i => $isbn) {
        $placeholders[] = ":isbn" . $i;
    }

    $query = "SELECT ISBN, AR FROM KONYV WHERE ISBN IN (" . implode(",", $placeholders) . ")";
    $stmt = oci_parse($conn, $query);

    foreach ($isbnList as $i => $isbn) {
        oci_bind_by_name($stmt, ":isbn" . $i, $isbn);
    }

    oci_execute($stmt);

    $totalAmount = 0;
    while ($row = oci_fetch_assoc($stmt)) {
        $isbn = $row["ISBN"];
        $price = $row["AR"];
        $quantity = $cart[$isbn];
        $totalAmount += $price * $quantity;
    }

    oci_free_statement($stmt);

    $insertQuery = "INSERT INTO VASARLAS (DATUM, OSSZEG, SZALLITASI_CIM, FELHASZNALO)
                    VALUES (SYSDATE, :amount, :address, :username)";
    $insertStmt = oci_parse($conn, $insertQuery);
    oci_bind_by_name($insertStmt, ":amount", $totalAmount);
    oci_bind_by_name($insertStmt, ":address", $address);
    oci_bind_by_name($insertStmt, ":username", $username);

    if (oci_execute($insertStmt)) {
        oci_free_statement($insertStmt);
        oci_close($conn);

        echo "<script>alert('A rendelés sikeresen leadva!'); window.location.href='../../Front-end/confirmation.php';</script>";
        unset($_SESSION["cart"]);
        exit();
    } else {
        $e = oci_error($insertStmt);
        oci_free_statement($insertStmt);
        oci_close($conn);
        die("Hiba a vásárlás rögzítésekor: " . $e["message"]);
    }
}
?>
