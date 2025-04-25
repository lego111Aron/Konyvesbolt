<?php
session_start();
session_unset();
session_destroy();

header("Location: ../../Front-end/login.php");
exit();
?>