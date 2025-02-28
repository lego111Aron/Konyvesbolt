<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["item_id"])) {
        $item_id = $_POST["item_id"];
        
        $_SESSION["cart"][$item_id] = isset($_SESSION["cart"][$item_id]) ? $_SESSION["cart"][$item_id] + 1 : 1;
        
        $_SESSION["cart_added"] = true;
    }
}

header("Location: " . $_SERVER["HTTP_REFERER"]);
exit();
?>
