<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['isbn'])) {
    $isbn = $_POST['isbn'];

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    if (isset($_SESSION['cart'][$isbn])) {
        $_SESSION['cart'][$isbn]++;
    } else {
        $_SESSION['cart'][$isbn] = 1;
    }

    echo json_encode(['success' => true, 'cart' => $_SESSION['cart']]);
    exit;
}
echo json_encode(['success' => false]);
