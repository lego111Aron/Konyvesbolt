<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["id"])) {
        $id = $_POST["id"];

        $_SESSION["cart"][$id]--;

        if ($_SESSION["cart"][$id] == 0){
            unset($_SESSION["cart"][$_POST["id"]]);
        }
    }
}

header("Location: ../?page=cart");
exit();
?>
