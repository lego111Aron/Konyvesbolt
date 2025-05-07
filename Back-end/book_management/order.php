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

    // 1. KÉSZLET ELLENŐRZÉS
    $isbnArray = [];
    $quantityArray = [];

    foreach ($cart as $isbn => $quantity) {
        $isbnArray[] = $isbn;
        $quantityArray[] = $quantity;
    }

    $isbnTable = oci_new_collection($conn, 'STR_ARRAY');
    $quantityTable = oci_new_collection($conn, 'NUM_ARRAY');

    foreach ($isbnArray as $i => $isbn) {
        $isbnTable->append($isbn);
        $quantityTable->append($quantityArray[$i]);
    }

    $checkProc = oci_parse($conn, "BEGIN ELLENORIZ_KESZLETET(:isbn_list, :darab_list); END;");
    oci_bind_by_name($checkProc, ":isbn_list", $isbnTable, -1, OCI_B_NTY);
    oci_bind_by_name($checkProc, ":darab_list", $quantityTable, -1, OCI_B_NTY);

    if (!oci_execute($checkProc)) {
        $e = oci_error($checkProc);
        $errorMessage = $e['message'];
    
        // Próbáljuk kibányászni a "user-friendly" részt
        if (preg_match('/ORA-20001: (.+?)ORA-06512:/s', $errorMessage, $matches)) {
            $userMessage = trim($matches[1]);
        } else {
            $userMessage = "Hiba történt a készletellenőrzés során.";
        }
    
        oci_free_statement($checkProc);
        oci_close($conn);
        echo "<script>alert('{$userMessage}'); window.location.href='../../Front-end/basket.php';</script>";
        exit();
    }
    

    oci_free_statement($checkProc);

    // 2. ÖSSZEG KISZÁMÍTÁS
    $totalAmount = isset($_POST["total"]) ? (float)$_POST["total"] : 0;

    if ($totalAmount <= 0) {
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
    }

    // 3. VÁSÁRLÁS LÉTREHOZÁSA
    $orderId = 0;
    $proc = oci_parse($conn, "BEGIN LETREHOZ_VASARLAS(:username, :address, :amount, :order_id); END;");
    oci_bind_by_name($proc, ":username", $username);
    oci_bind_by_name($proc, ":address", $address);
    oci_bind_by_name($proc, ":amount", $totalAmount);
    oci_bind_by_name($proc, ":order_id", $orderId, 32); // OUT paraméter

    if (oci_execute($proc)) {
        oci_free_statement($proc);

        // 4. KÖNYVEK HOZZÁADÁSA A VÁSÁRLÁSHOZ + KÉSZLET CSÖKKENTÉSE
        foreach ($cart as $isbn => $quantity) {
            // VASAROL tábla frissítése
            $bookProc = oci_parse($conn, "BEGIN HOZZAAD_VASAROLT_KONYV(:order_id, :isbn, :darab); END;");
            oci_bind_by_name($bookProc, ":order_id", $orderId);
            oci_bind_by_name($bookProc, ":isbn", $isbn);
            oci_bind_by_name($bookProc, ":darab", $quantity);
            oci_execute($bookProc);
            oci_free_statement($bookProc);

            // VAN tábla frissítése
            $stockProc = oci_parse($conn, "BEGIN KESZLET_CSOKKENT(:isbn, :darab); END;");
            oci_bind_by_name($stockProc, ":isbn", $isbn);
            oci_bind_by_name($stockProc, ":darab", $quantity);
            oci_execute($stockProc);
            oci_free_statement($stockProc);
        }

        oci_close($conn);
        unset($_SESSION["cart"]);
        echo "<script>alert('A rendelés sikeresen leadva!'); window.location.href='../../Front-end/books.php';</script>";
        exit();
    } else {
        $e = oci_error($proc);
        oci_free_statement($proc);
        oci_close($conn);
        die("Hiba a vásárlás rögzítésekor: " . $e["message"]);
    }
}
?>
