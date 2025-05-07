<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $isbn = $_POST['isbn'] ?? '';

    if (!empty($isbn) && isset($_SESSION['cart'][$isbn])) {
        unset($_SESSION['cart'][$isbn]);
    }
}

echo 'OK';
