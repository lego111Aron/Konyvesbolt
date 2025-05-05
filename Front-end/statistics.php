<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="StyleSheets/style.css">
    <title>Statisztikák</title>
    <?php
        include "../Back-end/connect.php";
        $array = array();
        //Költők a legtöbb eladott könyvvel
        $query = 
        $stmt = oci_parse($conn, $query);
        oci_execute($stmt);
        //fetch object-el kiolvasni a konyveket
        while ($row = oci_fetch_object($stmt)) {
            $array[] =$row;
        }
        
       
        oci_free_statement($stmt);
        echo"<pre>";
        echo"<br>";
        print_r($array);
        echo"</pre>";
     ?>
</head>
<body>
    <?php include "header.php"; ?>
</body>
</html>