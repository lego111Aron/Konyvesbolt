<?php
session_start();
include "../Back-end/connect.php";

$userAddress = '';

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username']; // A helyes változó
    $stmt = oci_parse($conn, "SELECT LAKCIM FROM FELHASZNALO WHERE FELHASZNALONEV = :username");
    oci_bind_by_name($stmt, ":username", $username);
    oci_execute($stmt);
    if ($row = oci_fetch_assoc($stmt)) {
        $userAddress = $row['LAKCIM'];
    }
}

$cart = $_SESSION['cart'] ?? [];
$booksInCart = [];

if (!empty($cart)) {
    $isbnList = array_keys($cart);
    $placeholders = [];
    foreach ($isbnList as $index => $isbn) {
        $placeholders[] = ":isbn" . $index;
    }

    $query = "SELECT ISBN, CIM, AR FROM KONYV WHERE ISBN IN (" . implode(',', $placeholders) . ")";
    $stmt = oci_parse($conn, $query);

    $isbnVars = []; // kulon valtozok tarolasa
    foreach ($isbnList as $index => $isbn) {
        $isbnVars[$index] = $isbn;
        oci_bind_by_name($stmt, ":isbn" . $index, $isbnVars[$index]);
    }

    oci_execute($stmt);
    while ($row = oci_fetch_assoc($stmt)) {
        $isbn = $row['ISBN'];
        $booksInCart[$isbn] = [
            'title' => $row['CIM'],
            'price' => $row['AR'],
            'quantity' => $cart[$isbn],
        ];
    }
}

$totalPrice = 0;
foreach ($booksInCart as $book) {
    $totalPrice += $book['price'] * $book['quantity'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="StyleSheets/style.css">
    <link rel="stylesheet" href="StyleSheets/basket_style.css">
    <title>Kosár</title>
</head>
<body>

    <!--Fejléc és a menü-->
    <?php include "header.php"; ?>

    <div id="chart-container">
        <h1>Kosár</h1>
        <?php if (!empty($booksInCart)): ?>
            <?php foreach ($booksInCart as $isbn => $book): ?>
                <form class="chart-item" action="../Back-End/book_management/update_item.php" method="POST">
                    <img src="../Back-end/img/<?= htmlspecialchars($isbn) ?>.jpg" alt="Könyv borító">
                    
                    <div class="chart-info">
                        <h2><?= htmlspecialchars($book['title']) ?></h2>
                        <p>ISBN: <?= htmlspecialchars($isbn) ?></p>
                        <h3>Ár: <?= htmlspecialchars($book['price']) ?> Ft</h3>
                    </div>
                    
                    <div class="chart-actions">
                        <input type="hidden" name="book_id" value="<?= htmlspecialchars($isbn) ?>">
                        <input type="number" name="quantity" value="<?= $book['quantity'] ?>" min="1" max="10">
                        <button type="submit">Módosít</button>
                        <input type="button" value="Törlés" onclick="removeFromCart('<?= htmlspecialchars($isbn) ?>')">
                    </div>
                </form>
                <hr>
            <?php endforeach; ?>
        <?php else: ?>
            <p>A kosár üres.</p>
        <?php endif; ?>

    </div>

    <div id="order-container">
        <h2>Rendelés véglegesítése</h2>
        <form action="../Back-End/book_management/order.php" method="POST">
            <input type="hidden" name="total" value="<?= htmlspecialchars($totalPrice) ?>">
            <div id="price">Végösszeg: <b><?= htmlspecialchars($totalPrice) ?> Ft</b></div>
            <label for="address">Szállítási cím:</label>
            <input type="text" id="address" name="address" value="<?= htmlspecialchars($userAddress) ?>" required>
            
            <fieldset>
                <!--Kártya adatokat nem mentünk el, csak itt van, hogy élethű legyen-->
                <legend>Bankkártya adatok</legend>

                <label for="card_number">Kártyára írt név:</label>
                <input type="text" id="card_name" name="card_name" placeholder="Valami Név"  required>
                <label for="card_number">Kártya szám:</label>
                <input type="text" id="card_number" name="card_number" pattern="\d{16}" placeholder="xxxxxxxxxxxxxxxx" required>

                <div class="card-details">
                    <div class="expiration-date">
                        <label for="expiry_date">Lejárat:</label>
                        <input type="month" id="expiry_date" name="expiry_date" required>
                    </div>
                    <div class="cvv">
                        <label for="cvv">CVV:</label>
                        <input type="text" id="cvv" name="cvv" pattern="\d{3}" placeholder="XXX" required>
                    </div>
                </div>
            </fieldset>
            <br>
            <button type="submit">Rendelés leadása</button>
        </form>

    </div>

    <script>
    function removeFromCart(isbn) {
        if (confirm("Biztosan törölni szeretnéd ezt a könyvet a kosárból?")) {
            fetch('../Back-End/book_management/remove_item.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 'isbn=' + encodeURIComponent(isbn)
            }).then(response => {
                if (response.ok) {
                    location.reload(); // oldal újratöltése
                } else {
                    alert('Hiba történt a törlés során.');
                }
            });
        }
    }
    </script>
</body>
</html>