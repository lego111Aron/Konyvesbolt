<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['isbn'])) {
    $isbn = $_POST['isbn'];

    // Kosár inicializálása, ha nem létezik
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Ha már van ilyen könyv, növeljük a mennyiséget
    if (isset($_SESSION['cart'][$isbn])) {
        $_SESSION['cart'][$isbn]++;
    } else {
        $_SESSION['cart'][$isbn] = 1;
    }

    echo json_encode(['success' => true, 'cart' => $_SESSION['cart']]);
    exit;
}
echo json_encode(['success' => false]);
