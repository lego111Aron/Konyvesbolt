<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $isbn = $_POST['book_id'] ?? '';
    $quantity = (int) ($_POST['quantity'] ?? 1);

    if (!empty($isbn)) {
        if ($quantity > 0) {
            $_SESSION['cart'][$isbn] = $quantity;
        } else {
            unset($_SESSION['cart'][$isbn]);
        }
    }
}

header("Location: ../../Front-end/basket.php");
exit;
